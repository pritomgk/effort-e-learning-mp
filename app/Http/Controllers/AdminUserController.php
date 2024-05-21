<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    
    public function admin_register(){
        return view('admin_view.common.register');
    }

    public function admin_login(){
        return view('admin_view.common.login');
    }


}



