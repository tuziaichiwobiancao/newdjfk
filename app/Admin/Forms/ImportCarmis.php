<?php

namespace App\Admin\Forms;

use App\Models\Carmis;
use App\Models\Goods;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\Storage;

class ImportCarmis extends Form
{

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        //dd($input);
        if($input["carmis_txt"] != null){
            $file_type = explode(".",$input["carmis_txt"]);
            if($file_type[1] != "txt") {
                $dirname = storage_path('app/public') . "/" . $input["carmis_txt"];
                $zip = new \ZipArchive();
                if($zip->open($dirname) === true){
                    for($i=0; $i<$zip->numFiles; $i++) {
                        file_put_contents(storage_path('app/public')."/files/temp.txt", $zip->getNameIndex($i)."\r\n", FILE_APPEND);
                        $zip->extractTo($_SERVER['DOCUMENT_ROOT']."/session/", $zip->getNameIndex($i));
                    }
                    Storage::disk('public')->delete($input['carmis_txt']);
                    $input['carmis_txt'] = "files/temp.txt";
                    $zip->close();
                }else{
                    return $this->response()->error("打开压缩包失败");
                }
            }
            $file_contents = Storage::disk('public')->get($input['carmis_txt']);
            //if(strpos($file_contents,"----")!==false){
            //    $arr = explode("\r\n",$file_contents);
            //    foreach ($arr as $item){
            //        $smsInfo = explode("----",$item);
            //        $canshu = explode("=",$smsInfo[1])[1];
            //        $string = $smsInfo[1]."----".$smsInfo[0]."----".geturllist()."?string=".$canshu;
            //        //echo $string;
            //        file_put_contents(storage_path('app/public')."/files/temp.txt", $string."\r\n", FILE_APPEND);
            //    }
            //    Storage::disk('public')->delete($input['carmis_txt']);
            //    $input['carmis_txt'] = "files/temp.txt";
            //}
        }
        
        if (empty($input['carmis_list']) && empty($input['carmis_txt'])) {
            return $this->response()->error(admin_trans('carmis.rule_messages.carmis_list_and_carmis_txt_can_not_be_empty'));
        }
        $carmisContent = "";
        if (!empty($input['carmis_txt'])) {
            $carmisContent = Storage::disk('public')->get($input['carmis_txt']);
        }
        if (!empty($input['carmis_list'])) {
            $carmisContent = $input['carmis_list'];
        }
        $carmisData = [];
        $tempList = explode(PHP_EOL, $carmisContent);
        foreach ($tempList as $val) {
            if (trim($val) != "") {
                $carmisData[] = [
                    'goods_id' => $input['goods_id'],
                    'carmi' => trim($val),
                    'status' => Carmis::STATUS_UNSOLD,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
        }
        if ($input['remove_duplication'] == 1) {
            $carmisData = assoc_unique($carmisData, 'carmi');
        }
        Carmis::query()->insert($carmisData);
        // 删除文件
        Storage::disk('public')->delete($input['carmis_txt']);
        return $this
				->response()
				->success(admin_trans('carmis.rule_messages.import_carmis_success'))
				->location('/carmis');
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->confirm(admin_trans('carmis.fields.are_you_import_sure'));
        $this->select('goods_id')->options(
            Goods::query()->where('type', Goods::AUTOMATIC_DELIVERY)->pluck('gd_name', 'id')
        )->required();
        $this->textarea('carmis_list')
            ->rows(20)
            ->help(admin_trans('carmis.helps.carmis_list'));
        $this->file('carmis_txt')
            ->disk('public')
            ->uniqueName()
            ->accept('*')
            ->maxSize(512000)
            ->help(admin_trans('carmis.helps.carmis_list'));
        $this->switch('remove_duplication');
    }

}
