<?php

use Illuminate\Support\Facades\Route;


// public view 


Route::get('/', function () {
    return view('pub_view.home');
})->name('home');


// admin view 


Route::get('/admin', function () {
    return view('admin_view.main_admin.dashboard');
})->name('admin.dashboard');
