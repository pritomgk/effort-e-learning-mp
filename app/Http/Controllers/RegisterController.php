<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{

    public function admin_register(){
        return view('admin_view.common.register');
    }

}
