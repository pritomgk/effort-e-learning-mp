<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogOutController extends Controller
{
    
    public function logout(){
        session()->flush();
        return redirect(route('home'));
    }
    
}


