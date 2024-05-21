<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberUserController extends Controller
{
    public function member_register() {
        return view('member_view.register');
    }

    public function member_login() {
        return view('member_view.login');
    }

}



