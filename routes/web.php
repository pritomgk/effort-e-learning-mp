<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;




// public view 


Route::get('/home', function () {
    return view('pub_view.home');
})->name('home');

Route::get('/', function () {
    return redirect()->route('home');
});




// admin view 


Route::get('/admin_login', [LoginController::class, 'admin_login']
)->name('admin_login');

Route::get('/admin_register', [RegisterController::class, 'admin_register']
)->name('admin_register');

Route::prefix('/admin')->middleware('admin')->group(function(){

    Route::get('/dashboard', function () {
        return view('admin_view.director.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    
});

Route::prefix('/member')->middleware('member')->group(function(){

    Route::get('/dashboard', function () {
        return view('admin_view.director.dashboard');
    })->name('member.dashboard');
    
    Route::get('/', function () {
        return redirect()->route('member.dashboard');
    });

});

Route::get('/mail_test', function () {

    $subject = 'Test Message received.';

    $body = '
    Hello Sir, <br><br>
    Thank you <br>
    Effort E-learning MP.
    ';

    Mail::to('pritomguha62@gmail.com')->send(new SendMail($subject, $body));

    return "Mail Sent..!";

});





