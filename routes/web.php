<?php

use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PubController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\MemberUserController;

// public view 


Route::get('/home', function () {
    return view('pub_view.home');
})->name('home');

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/terms_condition', function () {
    return view('pub_view.terms_condition');
})->name('terms_condition');




// admin panel routes 


Route::get('/admin_login', [AdminUserController::class, 'admin_login']
)->name('admin_login');

Route::get('/admin_register', [AdminUserController::class, 'admin_register']
)->name('admin_register');

Route::prefix('/admin')->middleware('admin')->group(function(){

    Route::get('/dashboard', function () {
        return view('admin_view.director.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    
});


// member panel routes 


Route::get('/member/login', [MemberUserController::class, 'member_login'])->name('member.login');

Route::get('/member/register', [MemberUserController::class, 'member_register'])->name('member.register');


Route::prefix('/member')->middleware('member')->group(function(){

    Route::get('/dashboard', function () {
        return view('member_view.dashboard');
    })->name('member.dashboard');
    
    Route::get('/', function () {
        return redirect()->route('member.dashboard');
    });

});


// public routes 


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

Route::post('/contact_us', [PubController::class, 'contact_us']
)->name('contact_us');





