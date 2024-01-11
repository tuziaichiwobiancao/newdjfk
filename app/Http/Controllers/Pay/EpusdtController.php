<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */

namespace App\Http\Controllers\Pay;


use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class EpusdtController extends PayController
{
    public function gateway(string $payway, string $orderSN ,int $type = 0)
    {
        try {
            // 加载网关
            $this->loadGateWay($orderSN, $payway);
            //构造要请求的参数数组，无需改动
            $resh = json_decode(file_get_contents("https://api.exchangerate-api.com/v4/latest/USD"),true);
            $huilv = $resh["rates"]["CNY"];
            $amount = (int)$this->order->actual_price * $huilv;
            $parameter = [
                "amount" => $amount,//原价
                "order_id" => $this->order->order_sn, //可以是用户ID,站内商户订单号,用户名
                'redirect_url' => route('epusdt-return', ['order_id' => $this->order->order_sn]),
                'notify_url' => url($this->payGateway->pay_handleroute . '/notify_url'),
                'signature' => '',
            ];
            $parameter['signature'] = $this->epusdtSign($parameter, $this->payGateway->merchant_id);
            $client = new Client([
                'headers' => [ 'Content-Type' => 'application/json' ]
            ]);
            $response = $client->post($this->payGateway->merchant_pem, ['body' => json_encode($parameter)]);
            $body = json_decode($response->getBody()->getContents(), true);
            if (!isset($body['status_code']) || $body['status_code'] != 200) {
                if($type == 1){
                    return $body;
                }
                return $this->err(__('dujiaoka.prompt.abnormal_payment_channel') . $body['message'].$amount);
            }
            if($type == 0){
                return redirect()->away($body['data']['payment_url']);
            }
            $arr = [
                "status_code" => 200,
                "order_id" => $body["data"]["order_id"],        //订单号
                "money" => $body["data"]["actual_amount"],      //美金金额
                "token" => $body["data"]["token"],              //支付token或链接
                "amount" => $body["data"]["amount"],            //RMB金额
                "image" => "https://v.api.aa1.cn/api/api-qrcode/sc.php?text=".$body["data"]["token"]."&size=180",
            ];
            return $arr;
        } catch (RuleValidationException $exception) {
        } catch (GuzzleException $exception) {
            return $this->err($exception->getMessage());
        }
    }


    private function epusdtSign(array $parameter, string $signKey)
    {
        ksort($parameter);
        reset($parameter); //内部指针指向数组中的第一个元素
        $sign = '';
        $urls = '';
        foreach ($parameter as $key => $val) {
            if ($val == '') continue;
            if ($key != 'signature') {
                if ($sign != '') {
                    $sign .= "&";
                    $urls .= "&";
                }
                $sign .= "$key=$val"; //拼接为url参数形式
                $urls .= "$key=" . urlencode($val); //拼接为url参数形式
            }
        }
        $sign = md5($sign . $signKey);//密码追加进入开始MD5签名
        return $sign;
    }

    public function notifyUrl(Request $request)
    {
        $data = $request->all();
        $order = $this->orderService->detailOrderSN($data['order_id']);
        //dd($order);
        if (!$order) {
            return 'fail';
        }
        $payGateway = $this->payService->detail($order->pay_id);
        if (!$payGateway) {
            return 'fail';
        }
        if($payGateway->pay_handleroute != 'pay/epusdt'){
            return 'fail';
        }
        $signature = $this->epusdtSign($data, $payGateway->merchant_id);
        if ($data['signature'] != $signature) { //不合法的数据
            return 'fail';  //返回失败 继续补单
        } else {
            //合法的数据
            //业务处理
            $this->orderProcessService->completedOrder($data['order_id'], $data['amount'], $data['trade_id']);
            send_goods($data['order_id']);
            return 'ok';
        }
    }

    public function returnUrl(Request $request)
    {
        $oid = $request->get('order_id');
        // 异步通知还没到就跳转了，所以这里休眠2秒
        sleep(2);
        return redirect(url('detail-order-sn', ['orderSN' => $oid]));
    }

}
