<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;

class ApiController extends BaseController{
    public function get_goods(){
        $group = DB::select("SELECT * FROM goods where is_open = 1");
        echo json_encode($group,JSON_UNESCAPED_UNICODE);
    }
}

