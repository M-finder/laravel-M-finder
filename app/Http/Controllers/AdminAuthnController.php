<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthnController extends Controller {

    public function __construct() {
        $this->middleware('guest:admin')->except('logout');
    }

    public function show_login() {
        return view('auth.admin_login');
    }

    
    public function login() {
        $request = request('data');
        if($request['name']==''){
            return response()->json(['code'=>1,'msg'=>'请输入用户名']);
        }
        if($request['password']==''){
            return response()->json(['code'=>1,'msg'=>'请输入用户名']);
        }
        if($request['_token']==''){
            return response()->json(['code'=>1,'msg'=>'哪儿来的滚哪儿去']);
        }
        if (Auth::guard('admin')->attempt(['name' => $request['name'], 'password' => $request['password']])) {
            $admin = Auth::guard('admin')->user();
            return response()->json(['code'=>0,'msg'=>'欢迎回来','data'=>$admin]);
        }

        return response()->json(['code'=>1,'msg'=>'用户名或密码错误']);
    }

}
