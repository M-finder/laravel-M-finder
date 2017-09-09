<?php

namespace App\Http\Controllers\UserHome;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

class UserController extends AuthController {

    public function myarticles() {
        return view('userhome.myarticles');
    }
    
    public function infoset(){
        return view('userhome.infoset');
    }

}
