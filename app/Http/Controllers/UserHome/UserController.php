<?php

namespace App\Http\Controllers\UserHome;

use App\User;
use App\Feedback;
use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends AuthController {

    public function myarticles() {
        return view('userhome.myarticles');
    }

    public function infoset() {
        return view('userhome.infoset');
    }

    public function message() {
        $uid = request('uid');
        $msg = Message::where('uid', '=', $uid)->where('status', '=', 0)->count();
        return response()->json(['code' => 0, 'count' => $msg]);
    }

    public function messageread() {
        $uid = Auth::user()->id;
        $msg = Message::where('uid', '=', $uid)->update(['status' => 1]);
        return response()->json(['code' => 0, 'count' => $msg]);
    }

    public function messages() {
        return view('userhome.messages');
    }

    public function mymessages() {
        $uid = request('uid');
        $per_page = request('per_page', 20);
        $msg = Message::where('uid', '=', $uid)->paginate($per_page)->toArray();
        return response()->json(['code' => 0, 'msg' => '操作成功', 'count' => $msg['total'], 'data' => $msg['data']]);
    }

    public function edit_sign() {
        $sign = request('sign');
        $uid = Auth::user()->id;
        User::where('id', '=', $uid)->update(['sign' => $sign]);
        return response()->json(['code' => 0, 'msg' => '修改成功']);
    }

    public function password_reset() {
        $oldpwd = request('oldpassword');
        $uid = Auth::user()->id;
        $user = User::find($uid);

        if (!Hash::check($oldpwd, $user->password)) {
            return $this->json_response(1, "原始密码错误", 1);
        } else {
            $pwd = request('password');
            $user->password = Hash::make($pwd);
            $user->save();
            return $this->json_response(0, "修改成功", 1);
        }
    }

    public function contact_back() {
        return view('userhome.contact_back')->with('token', md5('feedback' . time()));
    }

    public function feedback() {
        $data = request('data');
        $token = $data['token'];
        if ($token != Cookie::get('hasFeed' . $token)) {
            Cookie::queue('hasFeed' . "{$token}", $token, 10);
            unset($data['token'], $data['file']);
            $data['uid'] = Auth::user()->id;
            $data['status'] = 0;
            $data['reason'] = '待处理';
            $add = Feedback::create($data);
            return $this->json_response(0, "操作成功", $add);
        } else {
            return $this->json_response(1, "请勿重复提交", 0);
        }
    }

    public function feedbacks() {
        $uid =  Auth::user()->id;
        $per_page = request('per_page', 20);
        $feedbacks = Feedback::where('uid','=',$uid)->paginate($per_page)->toArray();
        foreach($feedbacks['data'] as $k=>$v){
            if($v['mid']==1){
                $feedbacks['data'][$k]['mid'] = '作者认证';
            }
            if($v['mid']==2){
                $feedbacks['data'][$k]['mid'] = 'BUG反馈';
            }
            if($v['mid']==3){
                $feedbacks['data'][$k]['mid'] = '友链申请';
            }
            if($v['mid']==4){
                $feedbacks['data'][$k]['mid'] = '其他';
            }
            if($v['status']==0){
                $feedbacks['data'][$k]['status'] = '未处理';
            }
            if($v['status']==2){
                $feedbacks['data'][$k]['status'] = '已处理';
            }
            if($v['status']==1){
                $feedbacks['data'][$k]['status'] = '拒绝';
            }
        }
        return response()->json(['code' => 0, 'msg' => '操作成功', 'count' => $feedbacks['total'], 'data' => $feedbacks['data']]);
    }

}
