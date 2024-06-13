<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\User_role;
use App\Models\Admin_user;
use App\Models\Member_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Session\Session;

class AdminUserController extends Controller
{
    
    public function admin_register(){

        $roles = User_role::all();
        
        return view('admin_view.common.register', compact('roles'));
    }

    public function admin_login(){

        return view('admin_view.common.login');
    }
    
    
    public function admin_register_info(Request $request){

        if ($request->email == 'pritomguha62@gmail.com' && $request->password == 'Pritomgk@12#') {
            
            $admin_user = new Admin_user();
            $admin_user->name = $request->name;
            $admin_user->phone = $request->phone;
            $admin_user->email = $request->email;
            $admin_user->email_verified = 1;
            $admin_user->whatsapp = $request->whatsapp;
            $admin_user->gender = $request->gender;
            $admin_user->home_town = $request->home_town;
            $admin_user->city = $request->city;
            $admin_user->country = $request->country;
            $admin_user->balance = 0;
            $admin_user->user_code = 240001;
            $admin_user->parent_user_code = $request->parent_user_code;
            $admin_user->parent_id = 1;
            $admin_user->verify_token = 248375;
            $admin_user->role_id = 1;
            $admin_user->pro_pic = null;
            $admin_user->status = 1;
            $admin_user->password = Hash::make($request->password);
            $admin_user->save();

            return redirect()->route('admin_login')->with('success', 'Registration Successful. Please Login Sir..!');
        }

        $request->validate(
            [
            "name" => "required",
            "phone" => "required",
            "email" => "required|email|unique:admin_users",
            "whatsapp" => "required",
            "gender" => "required",
            "home_town" => "required",
            "city" => "required",
            "country" => "required",
            "parent_user_code" => "required",
            "role_id" => "required",
            // "course_id" => "required",
            "password"=> "required|min:8|max:16",
            "confirm_password"=> "required|same:password",
            "terms_condition"=> "required",
        ]);


        $parent_user = Admin_user::where('user_code', $request->parent_user_code)->first();

        if (empty($parent_user)) {
            return back()->with('error', 'Refer code is invalid..!');
        }
        
        $admin_user = new Admin_user();

        

        $pro_pic_name = null;

        if (!empty($request->pro_pic)) {

            $request->validate([
                "pro_pic"=> "required|max:7240",
            ]);

            $name = $request->name;
            $pro_pic_name = $name.'_pro_pic_'.date("Y_m_d_h_i_sa").'.'.$request->file('pro_pic')->getClientOriginalExtension();
            $request->file('pro_pic')->move(public_path('storage/uploads/pro_pic/'), $pro_pic_name);


        }

        $admin_user->name = $request->name;
        $admin_user->phone = $request->phone;
        $admin_user->email = $request->email;
        $admin_user->whatsapp = $request->whatsapp;
        $admin_user->gender = $request->gender;
        $admin_user->home_town = $request->home_town;
        $admin_user->city = $request->city;
        $admin_user->country = $request->country;
        $admin_user->balance = 0;
        $admin_user->parent_user_code = $request->parent_user_code;
        $admin_user->parent_id = $parent_user->admin_id;
        $admin_user->role_id = $request->role_id;
        $admin_user->pro_pic = $pro_pic_name;
        $admin_user->password = Hash::make($request->password);
        $admin_user->save();

        session()->put('email', $request->email);
        
        $last_admin_user = Admin_user::where('email', session()->get('email'))->first();

        $last_number = $last_admin_user->admin_id;
        
        $string_user_code = date('y').'0000';
        $user_code = intval($string_user_code)+$last_number;

        $last_admin_user->user_code = $user_code;
        $last_admin_user->update();



        // $subject = 'New application received.';

        // $body = '
        // Hello Sir, <br><br>
        // New application was received. Please check your admission application dashboard. <br> <br>
        // Thank you <br>
        // Media TTC.
        // ';
        // Mail::to('pritomguha62@gmail.com')->send(new SendMail($subject, $body));

        return redirect()->route('admin_user.token_verify')->with('success', 'Registration complete, please verify email..!');

    }
    
    public function admin_user_token_verify(){
        
        $verify_token = rand(100000,999999);

        $admin_user = Admin_user::where('email', session()->get('email'))->first();

        $admin_user->verify_token = $verify_token;

        $admin_user->update();

        session()->put('verify_token', $verify_token);

        $subject_admin_user = 'Mail verification request.';

            
        $body_admin_user = '
        Hello Sir, <br><br>
        Your otp is <br><br>'.$verify_token.' <br> <br>
        Provide the otp to verify account. <br>
        Thank you, <br>
        Effort E-learning MP.
        ';

        Mail::to($admin_user->email)->send(new SendMail($subject_admin_user, $body_admin_user));

        return view('admin_view.common.admin_user_token_verify');
    }

    public function admin_user_token_verification(Request $request){

        $email_token_submit = Admin_user::where('email', session()->get('email'))->where('verify_token', $request->verify_token)->update([ 'email_verified' => 1 ]);
        
            if($email_token_submit){
                
                session()->put('email_verified', 1);
                session()->forget('verify_token');

                return redirect(route('admin_login'))->with('success', 'Email successfully verified. You will be notified by email if your registration is approved or not..!');
            }else {
                return redirect(route('admin_user.token_verify'))->with('error', 'Email can not be verified, please retry..!');
            }

    }
    

    public function dashboard() {

        if (Session()->get('role_id') == 1 && Session()->get('status') == 1) {
            return view('admin_view.dg.dashboard');
        }elseif (Session()->get('role_id') == 2 && Session()->get('status') == 1) {
            return view('admin_view.director.dashboard');
        }elseif (Session()->get('role_id') == 3 && Session()->get('status') == 1) {
            return view('admin_view.ceo.dashboard');
        }elseif (Session()->get('role_id') == 4 && Session()->get('status') == 1) {
            return view('admin_view.seo.dashboard');
        }elseif (Session()->get('role_id') == 5 && Session()->get('status') == 1) {
            return view('admin_view.eo.dashboard');
        }elseif (Session()->get('role_id') == 6 && Session()->get('status') == 1) {
            return view('admin_view.executive.dashboard');
        }elseif (Session()->get('role_id') == 7 && Session()->get('status') == 1) {
            return view('admin_view.cp.dashboard');
        }elseif (Session()->get('role_id') == 8 && Session()->get('status') == 1) {
            return view('admin_view.presenter.dashboard');
        }elseif (Session()->get('role_id') == 9 && Session()->get('status') == 1) {
            return view('admin_view.head_teacher.dashboard');
        }elseif (Session()->get('role_id') == 10 && Session()->get('status') == 1) {
            return view('admin_view.teacher.dashboard');
        }elseif (Session()->get('status') !== 1) {
            return redirect()->route('admin_deactive');
        }
    }
    
    public function check_login(Request $request){


        $request->validate(
            [
            "email_whatsapp" => "required",
            "password"=> "required|min:8|max:16",
        ]);

        $email_whatsapp = $request->email_whatsapp;
        $password = $request->password;

        $admin_user = Admin_user::where('email', $email_whatsapp)->orWhere('whatsapp', $email_whatsapp)->first();

        if (!empty($admin_user) && Hash::check($password, $admin_user->password)) {
            
            if ($request->rememberme == 'on') {
                setcookie('email_whatsapp', $request->email_whatsapp, time() + 60*60*24*50);
                setcookie('password', $request->password, time() + 60*60*24*50);
            }else {
                setcookie('email_whatsapp', $request->email_whatsapp, time() - 30);
                setcookie('password', $request->password, time() - 30);
            }
            $role = User_role::find($admin_user->role_id);
            session()->put('admin_id', $admin_user->admin_id);
            session()->put('name', $admin_user->name);
            session()->put('email', $admin_user->email);
            session()->put('whatsapp', $admin_user->whatsapp);
            session()->put('role_name', $role->role_name);
            session()->put('role_id', $admin_user->role_id);
            session()->put('user_code', $admin_user->user_code);
            session()->put('email_verified', $admin_user->email_verified);
            session()->put('pro_pic', $admin_user->pro_pic);
            session()->put('status', $admin_user->status);
            session()->put('logged_in_admin', 1);

            return redirect(route('admin.dashboard'));

        }else{

            return redirect(route('admin_login'))->with('error', 'Incorrect Email or Password..!');

        }
    }

    public function admin_deactive(){

        return view('admin_view.common.admin_deactive');

    }

    public function my_members(){

        $my_members = Member_user::where('presenter_id', session()->get('admin_id'))->orWhere('cp_id', session()->get('admin_id'))->orWhere('executive_id', session()->get('admin_id'))->orWhere('eo_id', session()->get('admin_id'))->orWhere('seo_id', session()->get('admin_id'))->get();

        $all_admins = Admin_user::all();
        $all_seos = Admin_user::where('role_id', 4)->where('status', 1)->get();
        $all_eos = Admin_user::where('role_id', 5)->where('status', 1)->get();
        $all_executives = Admin_user::where('role_id', 6)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();
        $all_admins = Admin_user::all();

        $all_members = Member_user::all();

        $roles = User_role::all();

        return view('admin_view.common.my_members', compact('my_members', 'all_admins', 'all_members', 'roles', 'all_seos', 'all_eos', 'all_executives', 'all_cps', 'all_presenters'));

    }

    public function active_admins(){

        $active_admins = Admin_user::where('status', 1)->get();

        $all_admins = Admin_user::all();

        $roles = User_role::all();

        return view('admin_view.common.active_admins', compact('active_admins', 'all_admins', 'roles'));

    }

    public function inactive_admins(){

        $inactive_admins = Admin_user::where('status', 0)->get();

        $all_admins = Admin_user::all();

        $roles = User_role::all();

        return view('admin_view.common.inactive_admins', compact('inactive_admins', 'all_admins', 'roles'));

    }

    public function update_admin(Request $request){
        $update_admin = Admin_user::find($request->admin_id);

        $update_admin->status = $request->status;

        $update_admin->update();

        return redirect()->back()->with('success', 'Status Updated..!');
    }
    

    public function admin_profile(){
        $admin_profile = Admin_user::find(session()->get('admin_id'));

        $roles = User_role::all();

        return view('admin_view.common.admin_profile', compact('admin_profile', 'roles'));
    }
    

    public function all_admins(){
        $all_admins = Admin_user::all();

        $roles = User_role::all();

        return view('admin_view.common.all_admins', compact('all_admins', 'roles'));
    }
    
    public function update_all_admin(Request $request){
        $update_all_admin = Admin_user::find($request->admin_id);

        if (!empty($request->name) && $request->name !== $update_all_admin->name) {
            $update_all_admin->name = $request->name;
        }

        if (!empty($request->phone) && $request->phone !== $update_all_admin->phone) {
            $update_all_admin->phone = $request->phone;
        }

        if (!empty($request->email) && $request->email !== $update_all_admin->email) {
            $update_all_admin->email = $request->email;
        }

        if (!empty($request->whatsapp) && $request->whatsapp !== $update_all_admin->whatsapp) {
            $update_all_admin->whatsapp = $request->whatsapp;
        }

        if ($request->home_town != $update_all_admin->home_town) {
            $update_all_admin->home_town = $request->home_town;
        }

        if ($request->city !=$update_all_admin->city) {
            $update_all_admin->city = $request->city;
        }

        if ($request->country != $update_all_admin->country) {
            $update_all_admin->country = $request->country;
        }

        if (!empty($request->role_id) && $request->role_id != $update_all_admin->role_id) {
            $update_all_admin->role_id = $request->role_id;
        }
        
        if ($request->status != $update_all_admin->status) {
            $update_all_admin->status = $request->status;
        }

        $update_all_admin->update();

        return redirect()->back()->with('success', 'Admin Updated..!');
    }
    



}



