<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UploadController extends Controller {
      public function upload_img(Request $request) {
        if (Auth::guest()) {
            return $this->json_response(1, "请先登录", 0);
        } else {
            $file = $request->file('file');
            if ($file->isValid()) {
                $originalName = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $realPath = $file->getRealPath(); 
                $type = $file->getClientMimeType(); 
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                $bool = Storage::disk('articles')->put($filename, file_get_contents($realPath));
                if ($filename) {
                    return response()->json(['code' => 0, 'msg' => '', 'data' => ['src' => '/images/articles/' . $filename, 'title' => $filename]]);
                }
            }
        }
    }
}
