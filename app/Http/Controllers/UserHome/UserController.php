<?php

namespace App\Http\Controllers\UserHome;

use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

class UserController extends AuthController {

    public function myarticles() {
        return view('userhome.myarticles');
    }
    
    public function infoset(){
        return view('userhome.infoset');
    }
    
    public function message(){
        $uid = request('uid');
        $msg = Message::where('uid', '=', $uid)->where('status','=',0)->count();
        return response()->json(['code' => 0, 'count' => $msg]);
    }
    
    public function messageread(){
        $uid = request('uid');
        $msg = Message::where('uid', '=', $uid)->update('status','=',1);
        return response()->json(['code' => 0, 'count' => $msg]);
    }

}
