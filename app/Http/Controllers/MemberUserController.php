<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Admin_user;
use App\Models\Course;
use App\Models\Member_user;
use App\Models\User_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Constraint\FileExists;

class MemberUserController extends Controller
{
    public function member_register() {

        $courses = Course::all();

        return view('member_view.register', compact('courses'));
    }

    public function member_login() {

        return view('member_view.login');
    }
    
    public function member_register_info(Request $request){

        $request->validate(
            [
            "name" => "required",
            "phone" => "required",
            "email" => "required|email|unique:member_users",
            "whatsapp" => "required",
            "gender" => "required",
            "home_town" => "required",
            "city" => "required",
            "country" => "required",
            "parent_user_code" => "required",
            // "course_id" => "required",
            "password"=> "required|min:8|max:16",
            "confirm_password"=> "required|same:password",
            "terms_condition"=> "required",
        ]);

        $parent_user_admin = Admin_user::where('user_code', $request->parent_user_code)->first();
        $parent_user_member = Member_user::where('user_code', $request->parent_user_code)->first();

        if (empty($parent_user_admin)) {
            if (empty($parent_user_member)) {
                return back()->with('error', 'Refer code is invalid..!');
            }
        }
        
        $member = new Member_user();

        

        $pro_pic_name = null;

        if (!empty($request->pro_pic)) {

            $request->validate([
                "pro_pic"=> "required|max:7240",
            ]);

            $name = $request->name;
            $pro_pic_name = $name.'_pro_pic_'.date("Y_m_d_h_i_sa").'.'.$request->file('pro_pic')->getClientOriginalExtension();
            $request->file('pro_pic')->move(public_path('storage/uploads/pro_pic/'), $pro_pic_name);


        }

        $member->name = $request->name;
        $member->phone = $request->phone;
        $member->email = $request->email;
        $member->whatsapp = $request->whatsapp;
        $member->gender = $request->gender;
        $member->home_town = $request->home_town;
        $member->city = $request->city;
        $member->country = $request->country;
        $member->balance = $request->balance;
        $member->gender = $request->gender;
        $member->parent_user_code = $request->parent_user_code;
        $member->course_id = $request->course_id;
        $member->pro_pic = $pro_pic_name;
        $member->role_id = 11;
        $member->password = Hash::make($request->password);
        $member->save();

        session()->put('email', $request->email);
        
        $last_member_user = Member_user::where('email', session()->get('email'))->first();

        $last_number = $last_member_user->member_id;
        
        $string_user_code = date('y').'000000';

        $user_code = intval($string_user_code)+$last_number;

        $last_member_user->user_code = $user_code;

        $last_member_user->update();


        $subject = 'New application received.';

        $body = '
        Hello Sir, <br><br>
        New application was received. Please check your admission application dashboard. <br> <br>
        Thank you <br>
        Effort E-learning MP.
        ';
        Mail::to('mpeffortelearning@gmail.com')->send(new SendMail($subject, $body));

        return redirect()->route('member.token_verify')->with('success', 'Registration complete, please verify email..!');

    }
    
    public function member_token_verify(){
        
        $verify_token = rand(100000,999999);

        $member = Member_user::where('email', session()->get('email'))->first();
        
        $member->verify_token = $verify_token;
        $member->update();

        session()->put('verify_token', $verify_token);

        $subject_member = 'Mail verification request.';

            
        $body_member = '
        Hello Sir, <br><br>
        Your otp is <br><br>'.$verify_token.' <br> <br>
        Provide the otp to verify account. <br>
        Thank you, <br>
        Effort E-learning MP.
        ';

        Mail::to($member->email)->send(new SendMail($subject_member, $body_member));

        return view('member_view.member_token_verify');
    }

    public function member_token_verification(Request $request){

        $email_token_submit = Member_user::where('email', session()->get('email'))->where('verify_token', $request->verify_token)->update([ 'email_verified' => 1 ]);
        
            if($email_token_submit){
                
                session()->put('email_verified', 1);
                session()->forget('verify_token');

                return redirect(route('member.login'))->with('success', 'Email successfully verified. You will be notified by email if your registration is approved or not..!');
            }else {
                return redirect(route('member.token_verify'))->with('error', 'Email can not be verified, please retry..!');
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

        $member_user = Member_user::where('email', $email_whatsapp)->orWhere('whatsapp', $email_whatsapp)->first();

        if (!empty($member_user) && Hash::check($password, $member_user->password)) {
            
            if ($request->rememberme == 'on') {
                setcookie('email_whatsapp', $request->email_whatsapp, time() + 60*60*24*50);
                setcookie('password', $request->password, time() + 60*60*24*50);
            }else {
                setcookie('email', $request->email, time() - 30);
                setcookie('password', $request->password, time() - 30);
            }
            $role = User_role::find($member_user->role_id);
            session()->put('member_id', $member_user->member_id);
            session()->put('name', $member_user->name);
            session()->put('email', $member_user->email);
            session()->put('role_name', $role->role_name);
            session()->put('role_id', $member_user->role_id);
            session()->put('email_verified', $member_user->email_verified);
            session()->put('pro_pic', $member_user->pro_pic);
            session()->put('status', $member_user->status);
            session()->put('logged_in', 1);

            return redirect(route('member.dashboard'));

        }else{

            return redirect(route('member.login'))->with('error', 'Incorrect Email or Password..!');

        }
    }
    

    public function member_profile(){
        $member_profile = Member_user::find(session()->get('member_id'));

        return view('member_view.member_profile', compact('member_profile'));

    }
    

    public function presenter_approval(){
        $cp_approvals = Member_user::where('presenter_approval', 0)->where('presenter_id', null)->get();

        $all_presenters = Admin_user::where('role_id', 8)->get();

        $roles = User_role::all();

        return view('admin_view.common.cp_approval', compact('cp_approvals', 'all_presenters', 'roles'));

    }
    

    public function cp_approvals(){
        $cp_approvals = Member_user::where('presenter_approval', 0)->where('presenter_id', null)->get();

        $all_presenters = Admin_user::where('role_id', 8);

        $roles = User_role::all();

        return view('admin_view.common.cp_approval', compact('cp_approvals', 'all_presenters', 'roles'));

    }
    

    public function update_cp_aprroval(Request $request){
        $update_cp_aprroval = Member_user::find('member_id', $request->member_id);
        $update_cp_aprroval->presenter_id = $request->presenter_id;


        return redirect()->back()->with('success', 'Member sent to presenter for approval..');

    }
    

    public function delete_member($member_id){
        $delete_member = Member_user::find($member_id);

        if (!empty($delete_member->pro_pic)) {
            if (file_exists(public_path('storage/uploads/pro_pic/'.$delete_member->pro_pic))) {
                unlink(public_path('storage/uploads/pro_pic/'.$delete_member->pro_pic));
            }
        }

        $delete_member->delete();


        return redirect()->back()->with('error', 'Member deleted..');

    }
    

    // public function executive_approval(){
    //     $update_admin = Admin_user::find($request->admin_id);

    //     $update_admin->status = $request->status;

    //     $update_admin->update();

    //     return redirect()->back()->with('success', 'Status Updated..!');
    // }
    

    // public function eo_approval(){
    //     $update_admin = Admin_user::find($request->admin_id);

    //     $update_admin->status = $request->status;

    //     $update_admin->update();

    //     return redirect()->back()->with('success', 'Status Updated..!');
    // }

    // public function seo_approval(){
    //     $update_admin = Admin_user::find($request->admin_id);

    //     $update_admin->status = $request->status;

    //     $update_admin->update();

    //     return redirect()->back()->with('success', 'Status Updated..!');
    // }
    

    // public function director_approval(){
    //     $update_admin = Admin_user::find($request->admin_id);

    //     $update_admin->status = $request->status;

    //     $update_admin->update();

    //     return redirect()->back()->with('success', 'Status Updated..!');
    // }
    

    public function dg_approvals(){

        $dg_approvals = Member_user::where('dg_id', null)->where('dg_approval', 0)->where('director_id', null)->where('director_approval', 0)->get();

        $all_directors = Admin_user::where('role_id', 2)->where('status', 1)->get();
        $all_seos = Admin_user::where('role_id', 4)->where('status', 1)->get();
        $all_eos = Admin_user::where('role_id', 5)->where('status', 1)->get();
        $all_executives = Admin_user::where('role_id', 6)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();

        $roles = User_role::all();

        $all_admins = Admin_user::all();

        $all_members = Member_user::all();

        return view('admin_view.common.dg_approval', compact('dg_approvals', 'all_directors', 'all_seos', 'all_eos', 'all_executives', 'all_cps', 'all_presenters', 'roles', 'all_admins', 'all_members'));
    }
    

    public function dg_approval_update(Request $request){

        $dg_approval_update = Member_user::find($request->member_id);

        $dg_approval_update->dg_id = session()->get('admin_id');

        if(!empty($request->director_id)){
            $dg_approval_update->director_id = $request->director_id;
        }

        if(!empty($request->seo_id)){
            $dg_approval_update->seo_id = $request->seo_id;
        }

        if(!empty($request->eo_id)){
            $dg_approval_update->eo_id = $request->eo_id;
        }

        if(!empty($request->executive_id)){
            $dg_approval_update->executive_id = $request->executive_id;
        }

        if(!empty($request->cp_id)){
            $dg_approval_update->cp_id = $request->cp_id;
        }

        if(!empty($request->presenter_id)){
            $dg_approval_update->presenter_id = $request->presenter_id;
        }

        if(!empty($request->status)){
            $dg_approval_update->status = $request->status;
        }

        $dg_approval_update->update();


        return back()->with('success', 'Request submited..!');
    }
    

    public function director_approvals(){

        $director_approvals = Member_user::where('dg_id', null)->where('dg_approval', 0)->where('director_id', null)->where('director_approval', 0)->get();

        $all_directors = Admin_user::where('role_id', 2)->where('status', 1)->get();
        $all_seos = Admin_user::where('role_id', 4)->where('status', 1)->get();
        $all_eos = Admin_user::where('role_id', 5)->where('status', 1)->get();
        $all_executives = Admin_user::where('role_id', 6)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();

        $roles = User_role::all();

        $all_admins = Admin_user::all();

        $all_members = Member_user::all();

        return view('admin_view.common.director_approvals', compact('director_approvals', 'all_admins', 'all_members', 'all_directors', 'all_seos', 'all_eos', 'all_executives', 'all_cps', 'all_presenters'));
    }
    
    public function director_approval_update(Request $request){

        $director_approval_update = Member_user::find($request->member_id);

        // $director_approval_update->dg_id = 1;
        // $director_approval_update->dg_id = 1;

        // if(!empty($request->director_id)){
            $director_approval_update->director_id = session()->get('admin_id');
        // }

        if(!empty($request->seo_id)){
            $director_approval_update->seo_id = $request->seo_id;
        }

        if(!empty($request->eo_id)){
            $director_approval_update->eo_id = $request->eo_id;
        }

        if(!empty($request->executive_id)){
            $director_approval_update->executive_id = $request->executive_id;
        }

        if(!empty($request->cp_id)){
            $director_approval_update->cp_id = $request->cp_id;
        }

        if(!empty($request->presenter_id)){
            $director_approval_update->presenter_id = $request->presenter_id;
        }

        if(!empty($request->status)){
            $director_approval_update->status = $request->status;
        }

        $director_approval_update->update();


        return back()->with('success', 'Request submited..!');
    }
    

    public function seo_approvals(){

        $seo_approvals = Member_user::where('dg_id', null)->where('dg_approval', 0)->where('director_id', null)->where('director_approval', 0)->get();

        $all_directors = Admin_user::where('role_id', 2)->where('status', 1)->get();
        $all_seos = Admin_user::where('role_id', 4)->where('status', 1)->get();
        $all_eos = Admin_user::where('role_id', 5)->where('status', 1)->get();
        $all_executives = Admin_user::where('role_id', 6)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();

        $roles = User_role::all();

        return view('admin_view.common.seo_approvals', compact('seo_approvals', 'all_directors', 'all_seos', 'all_eos', 'all_executives', 'all_cps', 'all_presenters'));
    }
    
    public function seo_approval_update(Request $request){

        $director_approval_update = Member_user::find($request->member_id);

        // $director_approval_update->dg_id = 1;
        // $director_approval_update->dg_id = 1;

        // if(!empty($request->director_id)){
            $director_approval_update->director_id = session()->get('admin_id');
        // }

        if(!empty($request->seo_id)){
            $director_approval_update->seo_id = $request->seo_id;
        }

        if(!empty($request->eo_id)){
            $director_approval_update->eo_id = $request->eo_id;
        }

        if(!empty($request->executive_id)){
            $director_approval_update->executive_id = $request->executive_id;
        }

        if(!empty($request->cp_id)){
            $director_approval_update->cp_id = $request->cp_id;
        }

        if(!empty($request->presenter_id)){
            $director_approval_update->presenter_id = $request->presenter_id;
        }

        if(!empty($request->status)){
            $director_approval_update->status = $request->status;
        }

        $director_approval_update->update();


        return back()->with('success', 'Request submited..!');
    }
    






}



