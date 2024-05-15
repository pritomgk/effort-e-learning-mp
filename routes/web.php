<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;




// public view 


Route::get('/', function () {
    return view('pub_view.home');
})->name('home');




// admin view 


Route::get('/admin', function () {
    return view('admin_view.main_admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin_login', [LoginController::class, 'admin_login']
)->name('admin_login');

Route::get('/admin_register', [RegisterController::class, 'admin_register']
)->name('admin_register');





