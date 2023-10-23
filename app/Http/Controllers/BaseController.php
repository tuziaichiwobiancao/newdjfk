<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class BaseController extends Controller
{

    /**
     * 渲染模板
     *
     * @param string $tpl 模板名称
     * @param array $data 数据
     * @param array $pageTitle 页面标题
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    protected function render(string $tpl, $data = [], string $pageTitle = '')
    {
        $layout = dujiaoka_config_get('template', 'unicorn');
        $tplPath = $layout . '/' .$tpl;
        return view($tplPath, $data)->with('page_title', $pageTitle);
    }

    /**
     * 错误提示
     *
     * @param string $content 提示内容
     * @param string $jumpUri 跳转url
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    protected function err(string $content, $jumpUri = '')
    {
        $layout = dujiaoka_config_get('template', 'unicorn');
        $tplPath = $layout . '/errors/error';
        return view($tplPath, ['title' => __('dujiaoka.error_title'), 'content' => $content, 'url' => $jumpUri])
            ->with('page_title', __('dujiaoka.error_title'));
    }

    public function saveMessage(){
        $message = file_get_contents("php://input");
        DB::transaction(function() use ($message){
            $res = DB::select("SELECT * FROM message WHERE message = ?",[$message]);
            if($res){
                exit("ERROR");
            }
            DB::insert("INSERT INTO message (message,addtime) values (?,?)",[$message,date("Y-m-d H:i:s",time())]);
        });
    }
    
    public function getOrderStatus($status){
        $arr = [
            "-1" => "已过期",
            "1" => "待支付",
            "2" => "待处理",
            "3" => "处理中",
            "4" => "已完成",
            "5" => "处理失败",
            "6" => "异常"
        ];
        return $arr[$status];
    }
}
