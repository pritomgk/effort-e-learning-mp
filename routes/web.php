<?php

use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PubController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\LogOutController;
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
)->name('admin_login')->middleware('logged_in_admin');

Route::post('/check_login', [AdminUserController::class, 'check_login']
)->name('check_login');

Route::get('/admin_register', [AdminUserController::class, 'admin_register']
)->name('admin_register');

Route::post('/admin_register_info', [AdminUserController::class, 'admin_register_info']
)->name('admin_register_info');

Route::get('/admin_user_token_verify', [AdminUserController::class, 'admin_user_token_verify']
)->name('admin_user.token_verify')->middleware('email_verified');

Route::post('/admin_user_token_verification', [AdminUserController::class, 'admin_user_token_verification']
)->name('admin_user.token_verification');

Route::prefix('/admin')->middleware('admin')->group(function(){

    Route::get('/dashboard', [AdminUserController::class, 'dashboard']
    )->name('admin.dashboard');
    
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/inactive_admins', [AdminUserController::class, 'inactive_admins']
    )->name('inactive_admins');

    Route::get('/active_admins', [AdminUserController::class, 'active_admins']
    )->name('active_admins');

    Route::get('/cp_approvals', [MemberUserController::class, 'cp_approvals']
    )->name('cp_approvals');

    Route::get('/dg_approvals', [MemberUserController::class, 'dg_approvals']
    )->name('dg_approvals')->middleware('director_general');
    

    Route::post('/dg_approval_update', [MemberUserController::class, 'dg_approval_update']
    )->name('dg_approval_update');
    

    Route::get('/director_approvals', [MemberUserController::class, 'director_approvals']
    )->name('director_approvals');
    

    Route::post('/director_approval_update', [MemberUserController::class, 'director_approval_update']
    )->name('director_approval_update');
    
    
    Route::get('/admin_profile', [AdminUserController::class, 'admin_profile']
    )->name('admin_profile');
    
    
    Route::post('/update_cp_aprroval', [MemberUserController::class, 'update_cp_aprroval']
    )->name('update_cp_aprroval');
    
        Route::get('/delete_member/{member_id}', [MemberUserController::class, 'delete_member']
        )->name('delete_member');
        
    

    Route::post('/update_admin', [AdminUserController::class, 'update_admin']
    )->name('update_admin');
    
    
});


// member panel routes 


Route::get('/member/login', [MemberUserController::class, 'member_login']
)->name('member.login')->middleware('logged_in');

Route::post('/member/check_login', [MemberUserController::class, 'check_login']
)->name('member.check_login');

Route::get('/member/register', [MemberUserController::class, 'member_register']
)->name('member.register');

Route::post('/member/register_info', [MemberUserController::class, 'member_register_info']
)->name('member.register_info');

Route::get('/member/token_verify', [MemberUserController::class, 'member_token_verify']
)->name('member.token_verify')->middleware('email_verified');

Route::post('/member/token_verication', [MemberUserController::class, 'member_token_verification']
)->name('member.token_verification');


Route::prefix('/member')->middleware('member')->group(function(){

    Route::get('/dashboard', function () {
        return view('member_view.dashboard');
    })->name('member.dashboard');
    
    Route::get('/', function () {
        return redirect()->route('member.dashboard');
    });
        
    Route::get('/member_profile', [MemberUserController::class, 'member_profile']
    )->name('member_profile');


});


// public routes 

Route::get('/logout', [LogOutController::class, 'logout']
)->name('logout');


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





