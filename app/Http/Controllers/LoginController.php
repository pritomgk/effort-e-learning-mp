<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function admin_login(){
        return view('admin_view.common.login');
    }

}
