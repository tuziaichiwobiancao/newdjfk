<?php

namespace App\Http\Controllers\Pay;
use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\DB;

class YueController extends PayController
{
    public function gateway(string $payway, string $orderSN ,int $type = 0){
        try {
            // 加载网关
            $this->loadGateWay($orderSN, $payway);
            $arr = explode("@",$this->order->email);
            $uid = $arr[0];
            $ress = DB::select("SELECT * FROM users WHERE uid = '".$uid."'");
            $dd = ["code" => 200,"msg"=>""];
            if(!$ress){
                $dd["code"] = 101;
                $dd["msg"] = "没有找到该用户信息";
                return $dd;
            }else{
                $res = $ress[0];
            }
            $yue = $res->money - (float)$this->order->actual_price;
            if($yue < 0){
                $dd["code"] = 101;
                $dd["msg"] = "您的余额不足,请充值后再购买";
                return $dd;
            }
            DB::update("UPDATE users SET money = $yue WHERE uid = '$uid'");
            $this->orderProcessService->completedOrder($orderSN, (float)$this->order->actual_price, $orderSN);
            $dd["msg"] = "付款成功,正在打包卡密请稍后";
            send_goods($orderSN);
            return $dd;
        } catch (RuleValidationException $exception) {
        } catch (GuzzleException $exception) {
            return $this->err($exception->getMessage());
        }
    }
}
