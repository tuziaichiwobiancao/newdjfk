<?php

namespace App\Http\Controllers\Bot;

use App\Admin\Forms\SystemSetting;
use App\Exceptions\RuleValidationException;
use App\Http\Controllers\BaseController;
use App\Models\Goods;
use App\Models\GoodsGroup;
use App\Models\Pay;
use Dcat\Admin\Form;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use TelegramBot\Api\Client;
use App\Models\Carmis;
use Illuminate\Http\Request;
class HomeController extends Base
{

    public function get(){
        echo 1;exit();
    }
    public function index()
    {
        //
        $this->saveMessage();
        $bottoken = dujiaoka_config_get("bottoken");
        $bot = new Client($bottoken);
        try {
            $bot->command('start', function ($message) use ($bot) {
                $uid = $message->getChat()->getId();
                $uname = $message->getChat()->getUsername();
                $nick = $message->getChat()->getFirstname()." ".$message->getChat()->getFirstname();
                try {
                    DB::insert("INSERT INTO users (uid,uname,nick,addtime) values (?,?,?,?)", [$uid, $uname, $nick, date("Y-m-d H:i:s", time())]);
                }catch (\Illuminate\Database\QueryException $e){}
                $res = DB::select("SELECT * FROM buttons WHERE keyword = 'start'")[0];
                $but = json_decode($res->button,true);
                if(!is_array($but)){
                    $but = null;
                }
                $button = new \TelegramBot\Api\Types\ReplyKeyboardMarkup($but, false,true);
                $bot->sendMessage($uid,$res->content,$res->parse,$res->disable,null,$button);
            });
            $bot->command('chongzhi', function ($message) use ($bot) {
                $uid = $message->getChat()->getId();
                $money = explode(" ",$message->getText());
                if(!array_key_exists(1,$money)){
                    $bot->sendMessage($uid,"请发送/chongzhi 金额,注意中间有空格");
                    exit();
                }
                $res = DB::select("SELECT * FROM buttons WHERE func = 'pay'")[0];
                $order = "CZ".date("YmdHis",time()).rand(1000,9999);
                $ress = $this->epusdt($order,$money[1]);
                //dd($ress);
                DB::insert("INSERT INTO recharge (uid,orderno,money,addtime,sign) values ('".$uid."','{$order}',".$money[1].",'".date("Y-m-d H:i:s",time())."','".$ress["sign"]."')");
                $content = str_replace("{orderno}",$order,$res->content);            //替换订单号
                $content = str_replace("{token}",$ress["data"]["token"],$content);            //替换订单号
                $content = str_replace("{money}",$ress["data"]["actual_amount"],$content);            //替换订单号
                $content = str_replace("{amount}",$ress["data"]["amount"],$content);            //替换订单号
                $img = dujiaoka_config_get("imgapi").$ress["data"]["token"]."&size=180";
                $bot->sendPhoto($uid,$img,$content,null,null,false,$res->parse);
            });
            $bot->on(function (\TelegramBot\Api\Types\Update $update) use ($bot) {
                if($update->getMessage()){
                    $text = $update->getMessage()->getText();
                    $call = $update->getMessage();
                    $ress = DB::select("SELECT * FROM buttons WHERE keyword = '".$text."'");
                    if(!$ress){
                        $orderinfo = $this->searchOrderBySN($text);
                        if($orderinfo){
                            $msg = "订单号:$text\n商品名:".$orderinfo["title"]."\n商品单价:".$orderinfo["goods_price"]." USDT\n购买数量:".$orderinfo["buy_amount"]."\n商品总金额:".$orderinfo["total_price"]." USDT\n订单状态:".$this->getOrderStatus($orderinfo["status"]);
                            if($orderinfo["status"] == 4){
                                $but = [[["text"=>"获取卡密","callback_data"=>"getkami_".$text]]];
                                $button = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($but);
                            }else{
                                $button = null;
                            }

                            $bot->sendMessage($update->getMessage()->getChat()->getId(),$msg,"HTML",false,null,$button);
                            exit();
                        }
                        $shopin = $this->cacheget($update->getMessage()->getChat()->getId());
                        if($shopin){
                            $it = explode("_",$shopin);
                            if($it[0] == "recharge"){
                                $charge = json_decode(dujiaoka_config_get("charge"),true);
                                $arr = [[
                                    ["text"=>"三个月 ".$charge["3"]." USDT","callback_data"=>"gogo_".$text."_3"],
                                    ["text"=>"六个月 ".$charge["6"]." USDT","callback_data"=>"gogo_".$text."_6"],
                                    ["text"=>"十二个月 ".$charge["12"]." USDT","callback_data"=>"gogo_".$text."_12"],
                                ]];
                                $string = "充值的用户名:{username}
                                请选择充值是的时间";
                                $bark = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($arr);
                                $content = str_replace("{username}",$text,$string);            //替换订单号
                                $bot->sendMessage($call->getChat()->getId(),$content,"HTML",false,null,$bark);
                                $this->cacheadd($update->getMessage()->getChat()->getId(),null);
                                exit();
                            }
                            $res = DB::select("SELECT * FROM buttons WHERE func = '".$it[0]."'")[0];
                            $shopinfo = $this->getGoodInfo($it[2]);
                            $content = str_replace("{name}",$shopinfo["gd_name"],$res->content);            //替换商品名
                            $content = str_replace("{description}",$shopinfo["gd_description"],$content);   //替换商品描述
                            $content = str_replace("{number}",$text,$content);   //替换购买数量
                            if($shopinfo["carmis_count"] == 0){
                                $content = str_replace("{carmis_count}",$shopinfo["carmis_count"]."   当前库存不足",$content);   //替换库存数量
                            }else{
                                $content = str_replace("{carmis_count}",$shopinfo["carmis_count"],$content);   //替换库存数量
                            }
                            $content = str_replace("{money}",$shopinfo["retail_price"],$content);   //替换商品金额
                            $jiannum = $text - 1;
                            if($jiannum == 0){
                                if($it[3] != 1){
                                    $bot->sendMessage($call->getChat()->getId(),"购买数量不能为0");
                                }
                                $jiannum = 1;
                            }
                            $jianum = $text + 1;
                            if($jianum > $shopinfo["carmis_count"]){
                                if($it[3] != 1){
                                    $bot->sendMessage($call->getChat()->getId(),"购买数量不能大于库存数量");
                                }
                                $jianum = $shopinfo["carmis_count"];
                            }
                            $but = [[["text"=>"数量-","callback_data"=>"shopinfo_".$it[1]."_".$it[2]."_".$jiannum],["text"=>"自定义数量","callback_data"=>"number"],["text"=>"数量+","callback_data"=>"shopinfo_".$it[1]."_".$it[2]."_".$jianum]]];
                            foreach ($shopinfo["payways"] as $item){
                                $but[] = [["text"=>$item["pay_name"],"callback_data"=>"confirmorder_".$it[1]."_".$it[2]."_".$text."_".$item["id"]]];
                            }
                            $but[] = [["text"=>"返回上一页","callback_data"=>"class_".$it[1]]];
                            $button = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($but);
                            $bot->sendMessage($update->getMessage()->getChat()->getId(),$content,"HTML",false,null,$button);
                            $this->cacheadd($update->getMessage()->getChat()->getId(),null);
                            exit();
                        }
                        $bot->sendMessage($update->getMessage()->getChat()->getId(),"没有找到该按钮信息");
                        exit();
                    }else{
                        $res = $ress[0];
                    }
                    if($res->func == "shoplist") {
                        $bb = $this->getGoodsGroup();
                        foreach ($bb as $item){
                            $but[] = [["text"=>$item->gp_name,"callback_data"=>"class_".$item->id]];
                        }
                        $button = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($but);
                        $bot->sendMessage($update->getMessage()->getChat()->getId(),$res->content,"HTML",false,null,$button);
                        exit();
                    }
                    if($res->func == "orderlist"){
                        $orderlist = $this->searchOrderByEmail($update->getMessage()->getChat()->getId()."@qq.com");
                        if(!$orderlist){
                            $bot->sendMessage($update->getMessage()->getChat()->getId(),"订单列表为空");
                            exit();
                        }
                        $but = null;
                        $str = "";
                        foreach ($orderlist as $item){
                            $str =$str. "订单号:".$item["order_sn"]." 状态:".$this->getOrderStatus($item["status"])." 商品名:".$item["title"]."\n";
                            if($item["status"] == 4){
                                $but[] = [["text"=>$item["order_sn"]." 获取卡密","callback_data"=>"getkami_".$item["order_sn"]]];
                            }
                        }
                        if(!$but){
                            $bot->sendMessage($update->getMessage()->getChat()->getId(),$str);
                        }else{
                            $button = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($but);
                            $bot->sendMessage($update->getMessage()->getChat()->getId(),$str,"HTML",false,null,$button);
                        }
                        exit();
                    }
                    $userinfo = DB::select("SELECT * FROM users where uid = ".$update->getMessage()->getChat()->getId())[0];
                    $res->content = str_replace("{uid}",$update->getMessage()->getChat()->getId(),$res->content);            //替换商品名
                    $res->content = str_replace("{username}",$userinfo->uname,$res->content);            //替换商品名
                    $res->content = str_replace("{nick}",$userinfo->nick,$res->content);            //替换商品名
                    $res->content = str_replace("{money}",$userinfo->money,$res->content);            //替换商品名
                    $res->content = str_replace("{points}",$userinfo->points,$res->content);            //替换商品名
                    $res->content = str_replace("{addtime}",$userinfo->addtime,$res->content);            //替换商品名
                    $but = json_decode($res->button, true);
                    if (!is_array($but)) {
                        $bot->sendMessage($update->getMessage()->getChat()->getId(),$res->content,$res->parse,$res->disable);
                        exit();
                    }
                    $button = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($but);
                    $bot->sendMessage($update->getMessage()->getChat()->getId(),$res->content,$res->parse,$res->disable,null,$button);
                }
                if($update->getCallbackQuery()){
                    $text = $update->getCallbackQuery()->getData();
                    $call = $update->getCallbackQuery()->getMessage();
                    $it = explode("_",$text);
                    //dd($it);
                    $resk = DB::select("SELECT * FROM buttons WHERE func = '".$it[0]."'");
                    if(!$resk){
                        $bot->sendMessage($call->getChat()->getId(),"没有该按钮方法");
                    }else{
                        $res = $resk[0];
                    }
                    //dd($res);
                    //0=方法名,1=分类id,2=商品id,3=购买数量,4=支付方式
                    switch ($it[0]){
                        case "class":
                            //获取商品列表
                            $goodslist = $this->getGoods($it[1]);
                            //var_dump($goodslist);
                            foreach ($goodslist as $item){
                                $but[] = [["text"=>$item["gd_name"],"callback_data"=>"shopinfo_".$it[1]."_".$item["id"]."_1"]];
                            }
                            $but[] = [["text"=>"返回上一页","callback_data"=>"classlist"]];
                            $content = $res->content;
                            break;
                        case "classlist":
                            //分类列表
                            $bb = $this->getGoodsGroup();
                            foreach ($bb as $item){
                                $but[] = [["text"=>$item->gp_name,"callback_data"=>"class_".$item->id]];
                            }
                            $content = $res->content;
                            break;
                        case "shopinfo":
                            $this->cacheadd($call->getChat()->getId(),$text);
                            //商品详细信息
                            $shopinfo = $this->getGoodInfo($it[2]);
                            $content = str_replace("{name}",$shopinfo["gd_name"],$res->content);            //替换商品名
                            $content = str_replace("{description}",$shopinfo["gd_description"],$content);   //替换商品描述
                            $content = str_replace("{number}",$it[3],$content);   //替换购买数量
                            if($shopinfo["carmis_count"] == 0){
                                $content = str_replace("{carmis_count}",$shopinfo["carmis_count"]."   当前库存不足",$content);   //替换库存数量
                            }else{
                                $content = str_replace("{carmis_count}",$shopinfo["carmis_count"],$content);   //替换库存数量
                            }
                            $content = str_replace("{money}",$shopinfo["retail_price"],$content);   //替换商品金额
                            $jiannum = $it[3] - 1;
                            if($jiannum == 0){
                                if($it[3] != 1){
                                    $bot->sendMessage($call->getChat()->getId(),"购买数量不能为0");
                                }
                                $jiannum = 1;
                            }
                            $jianum = $it[3] + 1;
                            if($jianum > $shopinfo["carmis_count"]){
                                if($it[3] != 1){
                                    $bot->sendMessage($call->getChat()->getId(),"购买数量不能大于库存数量");
                                }
                                $jianum = $shopinfo["carmis_count"];
                            }
                            $but = [[["text"=>"数量-","callback_data"=>"shopinfo_".$it[1]."_".$it[2]."_".$jiannum],["text"=>"自定义数量","callback_data"=>"number"],["text"=>"数量+","callback_data"=>"shopinfo_".$it[1]."_".$it[2]."_".$jianum]]];
                            foreach ($shopinfo["payways"] as $item){
                                $but[] = [["text"=>$item["pay_name"],"callback_data"=>"confirmorder_".$it[1]."_".$it[2]."_".$it[3]."_".$item["id"]]];
                            }
                            $but[] = [["text"=>"返回上一页","callback_data"=>"class_".$it[1]]];

                            break;
                        case "confirmorder":
                            //确认订单信息
                            $orderinfo = $this->confirmOrder($it[2],$it[3],$it[4],$call->getChat()->getId()."@qq.com");
                            $content = str_replace("{orderno}",$orderinfo["order_sn"],$res->content);            //替换订单号
                            $content = str_replace("{title}",$orderinfo["title"],$content);            //替换商品名
                            $content = str_replace("{goods_price}",$orderinfo["goods_price"],$content);            //替换商品单价
                            $content = str_replace("{buy_amount}",$orderinfo["buy_amount"],$content);            //替换购买数量
                            $content = str_replace("{total_price}",$orderinfo["total_price"],$content);            //替换商品总价
                            $content = str_replace("{uid}",$call->getChat()->getId(),$content);            //替换购买者id
                            $content = str_replace("{pay_name}",$orderinfo["pay"]["pay_name"],$content);            //替换付款方式
                            $content = str_replace("{created_at}",$orderinfo["created_at"],$content);            //替换创建时间
                            $but = [[["text"=>"确认","callback_data"=>"gopay_".ucfirst($orderinfo["pay"]["pay_check"])."Controller_".$orderinfo["pay"]["pay_check"]."_".$orderinfo["order_sn"]],["text"=>"取消","callback_data"=>"clean_".$orderinfo["order_sn"]]]];
                            //dd($but);
                            break;
                        case "gopay":
                            //去支付
                            $payinfo = $this->gopay("\\App\\Http\\Controllers\\Pay\\".$it[1],$it[2],$it[3]);
                            //dd($payinfo);
                            if($it[2] == "yue"){
                                $bot->sendMessage($call->getChat()->getId(),$payinfo["msg"]);
                                exit();
                            }
                            if($payinfo["status_code"] != 200){
                                $bot->sendMessage($call->getChat()->getId(),$payinfo["message"]);
                                exit();
                            }
                            $content = str_replace("{orderno}",$payinfo["order_id"],$res->content);            //替换订单号
                            $content = str_replace("{money}",$payinfo["money"],$content);            //替换美金金额
                            $content = str_replace("{token}",$payinfo["token"],$content);            //替换收款TRC20地址
                            $content = str_replace("{amount}",$payinfo["amount"],$content);            //替换RMB收款地址
                            $but = [[["text"=>"取消订单","callback_data"=>"clean_".$payinfo["order_id"]]]];
                            $button = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($but);
                            $bot->sendPhoto($call->getChat()->getId(),$payinfo["image"],$content,null,$button,false,$res->parse);
                            exit();
                            break;
                        case "pay":
                            //余额充值
                            $order = "CZ".date("YmdHis",time()).rand(1000,9999);
                            $ress = $this->epusdt($order,$it[1]);
                            //dd($ress);
                            DB::insert("INSERT INTO recharge (uid,orderno,money,addtime,sign) values ('".$call->getChat()->getId()."','{$order}',".$it[1].",'".date("Y-m-d H:i:s",time())."','".$ress["sign"]."')");
                            $content = str_replace("{orderno}",$order,$res->content);            //替换订单号
                            $content = str_replace("{token}",$ress["data"]["token"],$content);            //替换订单号
                            $content = str_replace("{money}",$ress["data"]["actual_amount"],$content);            //替换订单号
                            $content = str_replace("{amount}",$ress["data"]["amount"],$content);            //替换订单号
                            $img = dujiaoka_config_get("imgapi").$ress["data"]["token"]."&size=180";
                            $bot->sendPhoto($call->getChat()->getId(),$img,$content,null,null,false,$res->parse);
                            exit();
                            break;
                        case "chongzhilist":
                            $ress = DB::select("SELECT * FROM recharge WHERE uid = '".$call->getChat()->getId()."' AND status = '1' ORDER BY id DESC LIMIT 5");
                            $content = "";
                            if(!$ress){
                                $content = "没有订单信息";
                            }
                            foreach ($ress as $item){
                                $content = $content . "订单号:".$item->orderno." 金额:".$item->money." 添加时间:".$item->addtime." 支付时间:".$item->paytime;
                            }
                            $but = [[["text"=>"返回首页","callback_data"=>"classlist"]]];
                            break;
                        case "getkami":
                            send_goods($it[1]);
                            $bot->deleteMessage($call->getChat()->getId(),$call->getMessageId());
                            exit();
                            break;
                        case "clean":
                            //取消订单
                            $bot->deleteMessage($call->getChat()->getId(),$call->getMessageId());
                            exit();
                        case "number":
                            $bot->sendMessage($call->getChat()->getId(),"请回复购买数量");
                            exit();
                            break;
                        case "recharge":
                            if($it[1] == "my"){
                                $charge = json_decode(dujiaoka_config_get("charge"),true);
                                $arr = [[
                                    ["text"=>"三个月 ".$charge["3"]." USDT","callback_data"=>"gogo_".$call->getChat()->getUsername()."_3"],
                                    ["text"=>"六个月 ".$charge["6"]." USDT","callback_data"=>"gogo_".$call->getChat()->getUsername()."_6"],
                                    ["text"=>"十二个月 ".$charge["12"]." USDT","callback_data"=>"gogo_".$call->getChat()->getUsername()."_12"],
                                ]];
                                $bark = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($arr);
                                $content = str_replace("{username}",$call->getChat()->getUsername(),$res->content);            //替换订单号
                                $bot->editMessageText($call->getChat()->getId(),$call->getMessageId(),$content,$res->parse,false,$bark);
                                exit();
                            }
                            $this->cacheadd($call->getChat()->getId(),$text);
                            $bot->sendMessage($call->getChat()->getId(),"请回复需要充值的TG用户名，无需输入＠或https://t.me/");
                            exit();
                        case "gogo":
                            $userinfo = DB::select("SELECT * FROM uid = '".$call->getChat()->getId()."'");
                            if(!$userinfo){
                                $bot->sendMessage($call->getChat()->getId(),"没有找到用户信息");
                                exit();
                            }
                            $charge = json_decode(dujiaoka_config_get("charge"),true);
                            $amount = $userinfo[0]->money - $charge[$it[2]];
                            if($amount < 0){
                                $bot->sendMessage($call->getChat()->getId(),"余额不足请先充值后再提交");
                                exit();
                            }
                            DB::select("UPDATE users SET money = $amount WHERE uid = '".$call->getChat()->getId()."' ");
                            $order = "P".date("YmdHis",time()).rand(100,999);
                            $username = $it[1];
                            $month = $it[2];
                            try {
                                Prime($it[1], $it[2]);
                                $bot->editMessageText($call->getChat()->getId(),$call->getMessageId(),"用户名:{$it[1]}\r\n时间:{$it[2]} 个月\r\n充值成功}","HTML",false,null);
                                $type = 1;
                            }catch(Exception $e){
                                DB::select("UPDATE users SET money = ".$userinfo[0]->money." WHERE uid = '".$call->getChat()->getId()."' ");
                                $bot->sendMessage($call->getChat()->getId(),$e->getMessage()."\r\n已退回余额");
                                $type = 0;
                            }
                            DB::insert("INSERT INTO prime (uid,order,username,month,status,addtime) values (?,?,?,?,?,?)", [$call->getChat()->getId(), $order,$username,$month,$type, date("Y-m-d H:i:s", time())]);
                            exit();
                        default:
                            $content = "没有找到该功能按钮";

                    }
                    $parse = $res->parse?$res->parse:"HTML";
                    $button = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($but);
                    $bot->editMessageText($call->getChat()->getId(),$call->getMessageId(),$content,$parse,false,$button);
                }
            }, function () {
                return true;
            });
            $bot->run();
        } catch (\TelegramBot\Api\Exception $e) {
            $e->getMessage();
        }
    }

    public function test(){
        echo Cache::get("6022284971");
        exit();
        send_goods("YIHEDIQA4ML8J5NH");
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/txt/1.txt", "21412341234");
        $caption = urlencode("订单号:123");
        $url1 = urlencode("https://dujiao.hyperindex.tk/txt/1.txt");
        $url = "https://api.telegram.org/bot".dujiaoka_config_get("bottoken")."/sendDocument";
        echo $url;
        $document = new \CURLFile($_SERVER['DOCUMENT_ROOT'] . "/txt/1.txt");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [ "chat_id"=>"6022284971","caption"=>"asdfasdasdfasdf","document" => $document]);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $out = curl_exec($ch);
        curl_close($ch);
    }

    //获取分类
    public function getGoodsGroup(){
        $group = DB::select("SELECT * FROM goods_group where is_open = 1");
        return $group;
    }

    //获取商品列表
    public function getGoods($classid){
        $goods = Goods::query()->withCount(['carmis'=>function($query){
            $query->where('status', Carmis::STATUS_UNSOLD);
        }])->where('group_id', $classid)
            ->orderBy('id', 'DESC')
            ->get();
        return $goods->toArray();
    }

    //获取商品详细信息
    public function getGoodInfo($id){
        try {
            $goodsService = app('Service\GoodsService');
            $payService = app('Service\PayService');
            $goods = $goodsService->detail($id);
            $goodsService->validatorGoodsStatus($goods);
            if (count($goods->coupon)) {
                $goods->open_coupon = 1;
            }
            $formatGoods = $goodsService->format($goods);
            // 加载支付方式.
            $client = Pay::PAY_CLIENT_PC;
            if (app('Jenssegers\Agent')->isMobile()) {
                $client = Pay::PAY_CLIENT_MOBILE;
            }
            $formatGoods->payways = $payService->pays($client);
            return json_decode(json_encode($formatGoods,JSON_UNESCAPED_UNICODE),true);
            //return $this->render('static_pages/buy', $formatGoods, $formatGoods->gd_name);
        } catch (RuleValidationException $ruleValidationException) {
            return $this->err($ruleValidationException->getMessage());
        }
    }

    //确认订单
    public function confirmOrder($gid,$by_amount,$payway,$email){
        DB::beginTransaction();
        try {
            $orderService = app('Service\OrderService');
            $orderProcessService = app('Service\OrderProcessService');
            $goods = $orderService->validatorGoodsBak($gid,$by_amount);
            $orderService->validatorLoopCarmisBak($gid,$by_amount);
            // 设置商品
            $orderProcessService->setGoods($goods);
            // 数量
            $orderProcessService->setBuyAmount($by_amount);
            // 支付方式
            $orderProcessService->setPayID($payway);
            // 下单邮箱
            $orderProcessService->setEmail($email);
            // ip地址
            $orderProcessService->setBuyIP("8.8.8.8");
            // 查询密码
            $orderProcessService->setSearchPwd("123456");
            // 创建订单
            $orders = $orderProcessService->createOrder();
            $order = $orderService->detailOrderSN($orders->order_sn);
            DB::commit();
            return json_decode(json_encode($order,JSON_UNESCAPED_UNICODE),true);
        } catch (RuleValidationException $exception) {
            DB::rollBack();
            return $this->err($exception->getMessage());
        }
    }

    //去支付
    public function gopay($payway,$paystring,$orderSN){
        $pay = new $payway();
        $res = $pay->gateway($paystring,$orderSN,1);

        return json_decode(json_encode($res,JSON_UNESCAPED_UNICODE),true);
        //return $res;
    }


    //通过订单号查询订单
    public function searchOrderBySN($orderSn){
        $orderService = app('Service\OrderService');
        $res = $orderService->detailOrderSN($orderSn);
        return json_decode(json_encode($res,JSON_UNESCAPED_UNICODE),true);
        //return $res;
    }

        //通过订单号查询订单
    public function searchOrderBySNApi($orderSn){
        $orderService = app('Service\OrderService');
        $res = $orderService->detailOrderSN($orderSn);
        echo json_encode($res,JSON_UNESCAPED_UNICODE);
        //return $res;
    }

    //通过用户查询订单列表
    public function searchOrderByEmail($mail){
        $orderService = app('Service\OrderService');
        $res = $orderService->withEmailAndPassword($mail, "123456");
        return json_decode(json_encode($res,JSON_UNESCAPED_UNICODE),true);
    }

    public function sendMess($mess){
        Cache::add("message",$mess);
    }


    public function epusdt($orderno,$money)
    {
        $ress = DB::select("SELECT * FROM pays WHERE id = 23")[0];
        $amount = $money * dujiaoka_config_get("huilv");
        $amount = (int)$amount;
        $notify_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/epnotify";;//Epusdt的异步回调地址，随便，无需管理的话
        $redirect_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/redirect.html";//Epusdt的同步跳转地址,付款成功后跳转到这里
        $order_id = $orderno;//(string)"USDT-" . date("YmdHis", time()) . rand(10000000, 99999999);//生成随机数用于订单号
        $key = $ress->merchant_id;//Epusdt的自定义密钥
        $str = 'amount=' . $amount . '&notify_url=' . $notify_url . '&order_id=' . $order_id . '&redirect_url=' . $redirect_url . $key;//拼接字符串用于MD5计算
        $signature = md5($str);//用MD5算法计算签名
        $data = json_encode(array('order_id' => $order_id,                           //生成数据包，用到了的数组转json的jsonencode
            'amount' => $amount,
            'notify_url' => $notify_url,
            'redirect_url' => $redirect_url,
            'signature' => $signature));
        $res = $this->curl_request($ress->merchant_pem, $data, 'post');        //发起Curl请求并获取返回数据到变量
        $result = json_decode($res, true);
        $result["sign"] = $signature;
        return $result;
    }



    public function curl_request($url, $data = null, $method = 'post', $header = array("content-type: application/json"), $https = true, $timeout = 5)
    {
        $ch = curl_init();//初始化
        curl_setopt($ch, CURLOPT_URL, $url);//访问的URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//只获取页面内容，但不输出
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//https请求 不验证证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//https请求 不验证HOST
        }
        if ($method != "GET") {
            if ($method == 'POST') {
                curl_setopt($ch, CURLOPT_POST, true);//请求方式为post请求
            }
            if ($method == 'PUT' || strtoupper($method) == 'DELETE') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); //设置请求方式
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//请求数据
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //模拟的header头
        //curl_setopt($ch, CURLOPT_HEADER, false);//设置不需要头信息
        $result = curl_exec($ch);//执行请求
        curl_close($ch);//关闭curl，释放资源
        return $result;
    }

    public function epnotify(Request $request){
        $data = $request->all();
        $res = DB::select("SELECT * FROM recharge WHERE orderno = '".$data['order_id']."'");
        if(!$res){
            return "fail";
        }
        $res = $res[0];
        //if($res->sign != $data['signature']){
        //    return "fail";
        //}
        if($res->status != 0){
            return "fail";
        }
        $user = DB::select("SELECT * FROM users WHERE uid = '".$res->uid."'");
        if(!$user){
            return "fail";
        }
        $userinfo = $user[0];
        $money = $userinfo->money + $res->money;
        DB::select("UPDATE users SET money = $money WHERE uid = '".$res->uid."' ");
        DB::select("UPDATE recharge SET status = '1' WHERE orderno = '".$data['order_id']."' ");
        $bot = new Client(dujiaoka_config_get("bottoken"));
        $bot->sendMessage($res->uid,"订单号:".$data['order_id']."\n金额:".$res->money." USDT\n账户余额:".$money." USDT\n状态:成功");
        return "ok";
    }


    //私信
    public function sendp(Request $request){
        $data = $request->all();
        $bot = new Client(dujiaoka_config_get("bottoken"));
        $bot->sendMessage($data["uid"],$data["message"]);
    }


}
