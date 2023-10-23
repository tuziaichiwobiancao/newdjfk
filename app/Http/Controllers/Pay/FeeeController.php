<?php

namespace App\Http\Controllers\Pay;

use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FeeeController extends PayController
{
    public function gateway(string $payway, string $orderSN ,int $type = 0){
        try {
            // 加载网关
            $this->loadGateWay($orderSN, $payway);
            $arr = [
                "status_code" => 200,
                "order_id" => $this->order->order_sn,        //订单号
                "money" => (float)$this->order->actual_price,      //美金金额
                "token" => $this->payGateway->merchant_id,              //支付token或链接
                "amount" => (float)$this->order->actual_price * 7.21,            //RMB金额
                "image" => "https://v.api.aa1.cn/api/api-qrcode/sc.php?text=".$this->payGateway->merchant_id."&size=180",
            ];
            return $arr;
        } catch (RuleValidationException $exception) {
        } catch (GuzzleException $exception) {
            return $this->err($exception->getMessage());
        }
    }
}
