<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Course;
use App\Models\Member_user;
use App\Models\User_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
            "email" => "required|email",
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

        $last_member = Member_user::latest()->first();
        $last_number = $last_member->member_id;
        
        $member = new Member_user();

        $user_code = date('y').'000001'+$last_number;
        
        $verify_token = rand(100000,999999);

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
        $member->verify_token = $verify_token;
        $member->whatsapp = $request->whatsapp;
        $member->gender = $request->gender;
        $member->home_town = $request->home_town;
        $member->city = $request->city;
        $member->country = $request->country;
        $member->balance = $request->balance;
        $member->user_code = $user_code;
        $member->gender = $request->gender;
        $member->parent_user_code = $request->parent_user_code;
        $member->course_id = $request->course_id;
        $member->pro_pic = $pro_pic_name;
        $member->role_id = 11;
        $member->password = Hash::make($request->password);
        $member->save();

        session()->put('email', $request->email);
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

        // $subject = 'New application received.';

        // $body = '
        // Hello Sir, <br><br>
        // New application was received. Please check your admission application dashboard. <br> <br>
        // Thank you <br>
        // Media TTC.
        // ';
        // Mail::to('pritomguha62@gmail.com')->send(new SendMail($subject, $body));

        return redirect()->route('member.token_verify')->with('success', 'Registration complete, please verify email..!');

    }
    
    public function member_token_verify(){
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
            "email" => "required|email",
            "password"=> "required|min:8|max:16",
        ]);

        $email = $request->email;
        $password = $request->password;

        $member_user = Member_user::where('email', $email)->first();

        if (!empty($member_user) && Hash::check($password, $member_user->password)) {
            
            if ($request->rememberme == 'on') {
                setcookie('email', $request->email, time() + 60*60*24*50);
                setcookie('password', $request->password, time() + 60*60*24*50);
            }else {
                setcookie('email', $request->email, time() - 30);
                setcookie('password', $request->password, time() - 30);
            }
            $role = User_role::find($member_user->role_id);
            session()->put('admin_id', $member_user->member_id);
            session()->put('name', $member_user->name);
            session()->put('email', $member_user->email);
            session()->put('role_name', $role->role_name);
            session()->put('role_id', $member_user->role_id);
            session()->put('email_verified', $member_user->email_verified);
            session()->put('status', $member_user->status);

            return redirect(route('member.dashboard'));

        }else{

            return redirect(route('member.login'))->with('error', 'Incorrect Email or Password..!');

        }
    }
    


    public function all_active_members(){
        
        $all_active_members = Member_user::where('status', 1)->orderByDesc('course_start')->get();

        $active_member_courses = Course::all();
        
        return view('admin_view.common.all_active_members', compact('all_active_members', 'active_member_courses'));

    }

    public function all_deactive_members(){
        
        $all_deactive_members = Member_user::where('status', 0)->get();

        $deactive_member_courses = Course::all();
        
        return view('admin_view.common.all_deactive_members', compact('all_deactive_members', 'deactive_member_courses'));

    }

    public function deactivate_member($member_id){
        
        $deactivate_member = Member_user::find($member_id);

        $deactivate_member->status = 0;

        $deactivate_member->update();
        
        return redirect()->back()->with('success', 'member deactivated..!');

    }

    public function activate_member($member_id){
        
        $activate_member = Member_user::find($member_id);

        $activate_member->status = 1;

        $activate_member->update();
        
        return redirect()->back()->with('success', 'member admited..!');

    }

    public function delete_member($member_id){
        
        $delete_member = Member_user::find($member_id);
        if ($delete_member->pro_pic != '') {
            if (file_exists(public_path('storage/uploads/pro_pic/'.$delete_member->pro_pic))) {
                unlink(public_path('storage/uploads/pro_pic/'.$delete_member->pro_pic));
            }
        }
        
        $delete_member->delete();

        return redirect()->back()->with('error', 'member Deleted..!');

    }

    public function admin_update_member($member_id){
        
        $admin_update_member = Member_user::find($member_id);
        $courses = Course::all();
        
        return view('admin_view.common.admin_update_member', compact('admin_update_member', 'courses'));

    }

    public function admin_update_member_info(Request $request){
        
        $request->validate(
            [
            "name" => "required",
            // "father_name" => "required",
            // "birth_date" => "required",
            // "mother_name" => "required",
            // "ssc_roll_no" => "required",
            // "hsc_roll_no" => "required",
            // "nid_num" => "required|numeric",
            // "ssc_year" => "required",
            // "hsc_year" => "required",
            // "ssc_from" => "required",
            // "hsc_from" => "required",
            // "ssc_regi_no" => "required",
            // "hsc_regi_no" => "required",
            // "ssc_grade" => "required",
            // "hsc_grade" => "required",
            "gender" => "required",
            "course_id" => "required",
            // "address" => "required",
            // "password"=> "required|min:8|max:16",
            // "confirm_password"=> "required|same:password",
            // "terms_condition"=> "required",
        ]);

        $existing_member = Member_user::find($request->member_id);
        

        
        if (!empty($request->pro_pic)) {
                
        
            $request->validate([
                "pro_pic"=> "required|max:10240",
            ]);

            if ($existing_member->pro_pic != '') {
                if (file_exists(public_path('storage/uploads/pro_pic/'.$existing_member->pro_pic))) {
                    unlink(public_path('storage/uploads/pro_pic/'.$existing_member->pro_pic));
                }
            }
            
            $name = $request->name;
            $pro_pic_name = $name.'_pro_pic_'.date("Y_m_d_h_i_sa").'.'.$request->file('pro_pic')->getClientOriginalExtension();

            $existing_member->pro_pic = $pro_pic_name;
            
            $request->file('pro_pic')->move(public_path('storage/uploads/pro_pic/'), $pro_pic_name);

        }

        $existing_member->name = $request->name;
        $existing_member->phone = $request->phone;
        $existing_member->email = $request->email;
        $existing_member->address = $request->address;
        $existing_member->role_id = 11;
        

        $existing_member->update();

        return redirect()->back()->with('success', 'member information upadated..!');


    }

    
    public function view_course_members($course_id){
        
        $view_course_members = Member_user::where('course_id', $course_id)->orderByDesc('course_start')->get();

        $course_member_courses = Course::all();
        
        return view('admin_view.common.view_course_members', compact('view_course_members', 'course_member_courses'));

    }





}



