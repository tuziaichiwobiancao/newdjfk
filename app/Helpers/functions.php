<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */


use App\Exceptions\AppException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

if (! function_exists('replace_mail_tpl')) {

    /**
     * 替换邮件模板
     *
     * @param array $mailtpl 模板
     * @param array $data 内容
     * @return array|false|mixed
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    function replace_mail_tpl($mailtpl = [], $data = [])
    {
        if (!$mailtpl) {
            return false;
        }
        if ($data) {
            foreach ($data as $key => $val) {
                $title = str_replace('{' . $key . '}', $val, isset($title) ? $title : $mailtpl['tpl_name']);
                $content = str_replace('{' . $key . '}', $val, isset($content) ? $content : $mailtpl['tpl_content']);
            }
            return ['tpl_name' => $title, 'tpl_content' => $content];
        }
        return $mailtpl;
    }
}


if (! function_exists('dujiaoka_config_get')) {

    /**
     * 系统配置获取
     *
     * @param string $key 要获取的key
     * @param $default 默认
     * @return mixed|null
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    function dujiaoka_config_get(string $key, $default = null)
    {
        $sysConfig = Cache::get('system-setting');
        return $sysConfig[$key] ?? $default;
    }
}

if (! function_exists('format_wholesale_price')) {

    /**
     * 格式化批发价
     *
     * @param string $wholesalePriceArr 批发价配置
     * @return array|null
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    function format_wholesale_price(string $wholesalePriceArr): ?array
    {
        $waitArr = explode(PHP_EOL, $wholesalePriceArr);
        $formatData = [];
        foreach ($waitArr as $key => $val) {
            if ($val != "") {
                $explodeFormat = explode('=', delete_html_code($val));
                if (count($explodeFormat) != 2) {
                    return null;
                }
                $formatData[$key]['number'] = $explodeFormat[0];
                $formatData[$key]['price'] = $explodeFormat[1];
            }
        }
        sort($formatData);
        return $formatData;
    }
}

if (! function_exists('delete_html_code')) {

    /**
     * 去除html内容
     * @param string $str 需要去掉的字符串
     * @return string
     */
    function delete_html_code(string $str): string
    {
        $str = trim($str); //清除字符串两边的空格
        $str = preg_replace("/\t/", "", $str); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
        $str = preg_replace("/\r\n/", "", $str);
        $str = preg_replace("/\r/", "", $str);
        $str = preg_replace("/\n/", "", $str);
        $str = preg_replace("/ /", "", $str);
        $str = preg_replace("/  /", "", $str);  //匹配html中的空格
        return trim($str); //返回字符串
    }
}

if (! function_exists('format_charge_input')) {

    /**
     * 格式化代充框
     *
     * @param string $charge
     * @return array|null
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    function format_charge_input(string $charge): ?array
    {
        $inputArr = explode(PHP_EOL, $charge);
        $formatData = [];
        foreach ($inputArr as $key => $val) {
            if ($val != "") {
                $explodeFormat = explode('=', delete_html_code($val));
                if (count($explodeFormat) != 3) {
                    return null;
                }
                $formatData[$key]['field'] = $explodeFormat[0];
                $formatData[$key]['desc'] = $explodeFormat[1];
                $formatData[$key]['rule'] = filter_var($explodeFormat[2], FILTER_VALIDATE_BOOLEAN);
            }
        }
        return $formatData;
    }
}

if (! function_exists('site_url')) {

    /**
     * 获取顶级域名 带协议
     * @return string
     */
    function site_url()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'] . '/';
        return $protocol . $domainName;
    }
}

if (! function_exists('md5_signquery')) {

    function md5_signquery(array $parameter, string $signKey)
    {
        ksort($parameter); //重新排序$data数组
        reset($parameter); //内部指针指向数组中的第一个元素
        $sign = '';
        $urls = '';
        foreach ($parameter as $key => $val) {
            if ($val == '') continue;
            if ($key != 'sign') {
                if ($sign != '') {
                    $sign .= "&";
                    $urls .= "&";
                }
                $sign .= "$key=$val"; //拼接为url参数形式
                $urls .= "$key=" . urlencode($val); //拼接为url参数形式
            }
        }
        $sign = md5($sign . $signKey);//密码追加进入开始MD5签名
        $query = $urls . '&sign=' . $sign; //创建订单所需的参数
        return $query;
    }
}

if (! function_exists('signquery_string')) {

    function signquery_string(array $data)
    {
        ksort($data); //排序post参数
        reset($data); //内部指针指向数组中的第一个元素
        $sign = ''; //加密字符串初始化
        foreach ($data as $key => $val) {
            if ($val == '' || $key == 'sign') continue; //跳过这些不签名
            if ($sign) $sign .= '&'; //第一个字符串签名不加& 其他加&连接起来参数
            $sign .= "$key=$val"; //拼接为url参数形式
        }
        return $sign;
    }
}

if (!function_exists('picture_ulr')) {

    /**
     * 生成前台图片链接 不存在使用默认图
     * @param string $file 图片地址
     * @param false $getHost 是否只获取图片前缀域名
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function picture_ulr($file, $getHost = false)
    {
        if ($getHost) return Storage::disk('admin')->url('');
        return $file ? Storage::disk('admin')->url($file) : url('assets/common/images/default.jpg');
    }
}

if (!function_exists('assoc_unique')) {
    function assoc_unique($arr, $key)
    {
        $tmp_arr = array();
        foreach ($arr as $k => $v) {
            if (in_array($v[$key], $tmp_arr)) {//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
                unset($arr[$k]);
            } else {
                $tmp_arr[] = $v[$key];
            }
        }
        sort($arr); //sort函数对数组进行排序
        return $arr;
    }
}

if(!function_exists("send_goods")){
    function send_goods($orderno){
        $orderService = app('Service\OrderService');
        $res = json_decode(json_encode($orderService->detailOrderSN($orderno), JSON_UNESCAPED_UNICODE), true);
        $kami = $res["info"];
        $kalist = explode("\n",$kami);
        //dd($kalist);
        $zip = new ZipArchive();
        $isfile = 1;    //是文件
        if($zip->open($_SERVER['DOCUMENT_ROOT']."/session/".$orderno.".zip",ZipArchive::CREATE) === true){
            foreach ($kalist as $item) {
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/session/" . $item)) {
                    $zip->addFile($_SERVER['DOCUMENT_ROOT'] . "/session/" . $item,$item);
                } else {
                    $isfile = 0;  //不是文件
                }
            }
            $zip->close();
        }
        $user = explode("@",$res["email"]);
        $caption ="订单号:$orderno";
        if($isfile){
            $bot = new \TelegramBot\Api\Client(dujiaoka_config_get("bottoken"));
            $bot->sendDocument($user[0],"https://".$_SERVER['HTTP_HOST']."/session/".$orderno.".zip",$caption);
            exit();
        }
        //if(isurl($kalist[0])){
        //    foreach($kalist as $item){
        //        $urlList = explode("----",$item);
        //        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/txt/".$orderno.".txt", $urlList[1]."----".$urlList[2]."\r\n",FILE_APPEND);
        //    }
        //}else{
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/txt/".$orderno.".txt", $kami);
        //}
        $url = "https://api.telegram.org/bot".dujiaoka_config_get("bottoken")."/sendDocument";
        $document = new \CURLFile($_SERVER['DOCUMENT_ROOT'] . "/txt/".$orderno.".txt");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [ "chat_id"=>$user[0],"caption"=>$caption,"document" => $document]);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $out = curl_exec($ch);
        curl_close($ch);
    }
}


if(!function_exists("isurl")){
    function isurl($string){
        if(filter_var($string,FILTER_VALIDATE_URL) !== false){
            return true;
        }else{
            return false;
        }
    }
}


if(!function_exists("geturllist")){
    function geturllist(){
        $arr = [
            "http://147.182.152.73/",
        ];

        $data = $arr[array_rand($arr)];
        return $data;
    }
}


if(!function_exists("Prime")){
    function Prime($user,$numt){
        $dom = dujiaoka_config_get("apiurl");
        if($dom == ""){
            throw new Exception("请在后台配置ton网络支付网关");
        }
        #技术文档阅读：https://telegra.ph/%E6%8A%93%E5%8F%96Telegram-Premium-%E8%B5%A0%E9%80%81%E4%BC%9A%E5%91%98API%E6%8E%A5%E5%8F%A3-04-23
        #社区：www.97bot.com
        #基本配置 - 以下两项请使用：获取cookie工具.exe 获得 （代码已开源）
        $hash = dujiaoka_config_get("hash");
        $cookie = dujiaoka_config_get("cookie");
        //$user = "gd801";//被开通用户的用户名不带@
        //$numt = 3; //开通月数 3 6 12  = 3个月 6个月  12个月
        #第一步 获取被赠送用户的会员信息
        //echo "【第一步】<br>";
        $user=curl_post_https("https://fragment.com/api?hash={$hash}","query={$user}&months={$numt}&method=searchPremiumGiftRecipient",null,$cookie);
        $json = json_decode($user,true); //json编码
        if(empty($json['ok'])){
            throw new Exception("获取被赠送用户的会员信息");
            //exit("第一步 获取被赠送用户的会员信息  失败");
        }
        $userName = $json['found']['name']??"未知";//获得用户昵称
        $recipient = $json['found']['recipient']; //获得用户唯一标识 第2步需要使用
        $photo = $json['found']['photo'];//获得用户头像
        //echo "用户头像：{$photo}<br>";
        //echo "用户昵称：{$userName}<br>";
        //echo "唯一标识：{$recipient}<br><br>";
        #第二步 创建ton支付订单 注意其中的 $recipient 是第一步获取的
        //echo "【第二步】<br>";
        $order=curl_post_https("https://fragment.com/api?hash={$hash}","recipient={$recipient}&months={$numt}&method=initGiftPremiumRequest",null,$cookie);
        $json = json_decode($order,true); //json编码
        if(empty($json['req_id'])){
            throw new Exception("创建订单失败");
            //exit("第二步 创建ton支付订单  失败");
        }
        $req_id = $json['req_id']; //获得订单号 后续都需要使用
        $amount = $json['amount'];
        //echo "订单号：{$req_id}<br>";
        //echo "金额(Ton)：{$amount}<br><br>";
        #第三步 确认支付订单
        //echo "【第三步】<br>";
        $order=curl_post_https("https://fragment.com/api?hash={$hash}","id={$req_id}&show_sender=1&method=getGiftPremiumLink",null,$cookie);
        $json = json_decode($order,true); //json编码
        if(empty($json['ok'])){
            throw new Exception("确认支付失败");
            //exit("第三步 确认支付订  失败");
        }
        $qr_link = $json['qr_link']; //获得支付地址（自己生成二维码） 任何TON钱包扫这个二维码支付就可以自动开通会员，当然这是手动模式了
        $expire = time() + $json['expire_after'];
        //echo "二维码链接：{$qr_link}<br>";
        //echo "订单有效期time：{$expire}<br>";
        //echo "订单有效期date：".date("Y-m-d H:i:s",$expire)."<br><br>";
        #第四步 解码订单数据 并调用TON接口 实现自动支付从而实现自动开通会员
        //echo "【第四步】<br>";
        $order=curl_get_https("https://fragment.com/tonkeeper/rawRequest?id={$req_id}&qr=1");
        $json = json_decode($order,true); //json编码
        if(empty($json['body']['params']['messages'])) {
            throw new Exception("解码订单数据失败");
            //exit("第四步 解码订单数据 失败");
        }
        //$money = base64_decode($json['body']['params']['messages'][0]['amount']); //最终支付金额(精度9) 也就是 amount * 1000000000
        $money = $json['body']['params']['messages'][0]['amount'] / 1000000000;
        //echo $money;
        $base32 = base64_decode($json['body']['params']['messages'][0]['payload']);
        //$base32 = $json['body']['params']['messages'][0]['payload'];//不是完整正确的解码
        //echo $base32;
        $base32 = explode("#",$base32);
        $base32 = urlencode("Telegram Premium for {$numt} months Ref#".$base32[1]);#最终(支付网关)订单数据 需要传递给golang 支付网关
        //echo "最终(支付网关)订单数据：{$base32}<br><br>";
        //exit("第5步 自动支付并自动开通会员(我注释了代码) 请看源代码 第73行");//代码运行到这里结束了，如果自己要测试支付开通请删除这行
        #第5步 由于只找到JAVA C++ GOlang 的 SDK，没有找到PHP版本的,所以这里我使用GOlang 网关（只负责Ton支付业务）  代码一并开源了的
        $raw = '{"EQBAjaOyi2wGWlk-EDkSabqqnF-MrrwMadnwqrurKpkla9nE":"'.$money.'"}';//这里面这个TON钱包地址就是fragment官方开会员的固定收款钱包地址 - 请参阅顶部技术文档
        //发起支付
        $url = $dom."/sendTransactions?comment={$base32}&send_mode=1";
        $payok  = curl_get_https($url,["Content-Type:application/json"],$raw);
        //127.0.0.1  是golang 支付网关运行在本地
        //echo "最终上链支付结果：{$payok}";
        $arr = json_decode($payok,true);
        if(isset($arr["error"])){
            throw new Exception("ton:".$arr["error"]);
        }
        return $payok;
        //后续可以自己
    }
}

function curl_get_https($url,$headers=null,$raw=null,$time=6){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_TIMEOUT, $time);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    if(!empty($headers)){
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);//设置请求头
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);  // 从证书中检查SSL加密算法是否存在
    if($raw){
        curl_setopt($curl, CURLOPT_POSTFIELDS, $raw); // Post提交的数据包
    }
    $tmpInfo = curl_exec($curl);     //返回api的json对象
    curl_close($curl);
    return $tmpInfo;
}


function curl_post_https($url,$data,$headers=null,$cookie=null){ // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
    // curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    // curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    if(!empty($headers)){
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);//设置请求头
    }
    if(!empty($cookie)){
        curl_setopt($curl, CURLOPT_COOKIE, $cookie); // 带上COOKIE请求
    }
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 10); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据
}
