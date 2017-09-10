<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UploadController extends Controller {

    public function upload_articles_img(Request $request) {
        if (Auth::guest()) {
            return $this->json_response(1, "请先登录", 0);
        } else {
            $file = $request->file('file');
            $res = $this->upload_img('articles', $file);
            return $res;
        }
    }

    public function upload_articles_avatar(Request $request) {
        if (Auth::guest()) {
            return $this->json_response(1, "请先登录", 0);
        } else {
            $file = $request->file('file');
            $res = $this->upload_img('avatar', $file);
            $uid = Auth::user()->id;
            User::where('id', '=', $uid)->update(['avatar' => $res['src']]);
            return response()->json($res);
        }
    }

    public function upload_img($path, $file) {
        if ($file->isValid()) {
            if ($file->getClientSize() > 2097152) {
                return $this->json_response(1, "请上传小于 2 mb 的图片", 0);
            }
            $ext = $file->getClientOriginalExtension();
            $realPath = $file->getRealPath();
            $type = $file->getClientMimeType();
            $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
            $bool = Storage::disk($path)->put($filename, file_get_contents($realPath));
            $url = Storage::disk($path)->url($filename);
            if ($filename) {
                return ['code' => 0, 'msg' => '', 'src' => $url, 'data'=>['src'=>$url,'title'=>$filename]]; //{"code": 0 ,"msg": "" ,"data": {"src": "图片路径","title": "图片名称"}
            }
        }
    }

}
