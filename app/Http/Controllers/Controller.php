<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
     const ERROR_NONE = 0;
     const ERROR_NULL = 1;
     const ERROR_BAD_PARAMS = 2;
     
    protected function json_response($code = ERROR_NONE, $msg = "操作成功。", $data = null) {
        return response()->json(["code" => $code, "msg" => $msg, "data" => $data]);
    }
}
