<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Admin_user;
use App\Models\Course;
use App\Models\Member_user;
use App\Models\Online_class;
use App\Models\Passbook;
use App\Models\User_role;
use App\Models\Withdrawal;
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
    

    public function dashboard() {

        if(session()->get('status') == 1){
            
            $member_user = Member_user::find(session()->get('member_id'));

            $courses = Course::all();

            $classes = Online_class::latest()->limit(1)->get();

            return view('member_view.dashboard', compact('courses', 'classes'));
        }else{
            return redirect()->route('member_deactive');
        }

    }
    
    public function member_register_info(Request $request){

        $request->validate(
            [
            "name" => "required",
            "phone" => "required|unique:member_users,phone",
            "email" => "required|email|unique:member_users,email",
            "whatsapp" => "required|unique:member_users,whatsapp",
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

        $parent_user_admin = Admin_user::where('user_code', $request->parent_user_code)->where('status', 1)->first();
        $parent_user_member = Member_user::where('user_code', $request->parent_user_code)->where('status', 1)->first();

        $member = new Member_user();
        $passbook = new Passbook();

        if (empty($parent_user_admin)) {
            if (empty($parent_user_member)) {
                return back()->with('error', 'Refer code is invalid..!');
            }else{

                $member_refer_active_count = Member_user::where('parent_user_code', $parent_user_member->user_code)->where('status', 1)->get()->count();
                
                $member_refer_count = Member_user::where('parent_user_code', $parent_user_member->user_code)->get()->count();

                if ($member_refer_active_count*20 >= $member_refer_count) {
                    $parent_user_member->balance = intval($parent_user_member->balance) + 1;
                    $passbook->sender_name = 'Refer Bonus';
                    $passbook->receiver_name = $parent_user_member->name;
                    $passbook->receiver_member_id = $parent_user_member->member_id;
                    $passbook->amount = 1;
                    $passbook->receiver_user_code = $parent_user_member->user_code;
                    $parent_user_member->update();
                }
                
            }
        }else {
            
            $admin_refer_active_count = Member_user::where('parent_user_code', $parent_user_admin->user_code)->where('status', 1)->get()->count();
                
            $admin_refer_count = Member_user::where('parent_user_code', $parent_user_admin->user_code)->get()->count();

            $member->group_leader_code = $parent_user_admin->user_code;

            // if ($admin_refer_active_count*20 >= $admin_refer_count) {
                $parent_user_admin->balance = intval($parent_user_admin->balance) + 1;
                $passbook->sender_name = 'Refer Bonus';
                $passbook->receiver_name = $parent_user_admin->name;
                $passbook->receiver_admin_id = $parent_user_admin->admin_id;
                $passbook->amount = 1;
                $passbook->receiver_user_code = $parent_user_admin->user_code;
                $parent_user_admin->update();
            // }
        }
        

        

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
        if (!empty($parent_user_admin)) {
            $member->group_leader_code = $parent_user_admin->user_code;
        }else {
            
            $group_leader = Admin_user::where('user_code', $parent_user_member->group_leader_code)->first();
            if (!empty($group_leader->user_code)) {
                $member->group_leader_code = $group_leader->user_code;
            }

        }
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

        $passbook->sender_user_code = $last_member_user->user_code;
        
        $passbook->save();

        session()->put('name', $last_member_user->name);
        session()->put('user_code', $last_member_user->user_code);
        session()->put('phone', $last_member_user->phone);
        session()->put('whatsapp', $last_member_user->whatsapp);
        session()->put('country', $last_member_user->country);

        $subject = 'New application received.';

        $body = '
        Hello Sir, <br><br>
        New application was received. Please check your admission application dashboard. <br> <br>
        Thank you <br>
        Effort E-learning MP.
        ';
        Mail::to('mpeffortelearning@gmail.com')->send(new SendMail($subject, $body));

        $last_member_user = Member_user::where('email', session()->get('email'))->first();

        return redirect()->back()->with('success', 'Registration complete, please contact us for activation..!');

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
            session()->put('user_code', $member_user->user_code);
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
    

    public function member_deactive(){

        return view('member_view.member_deactive');

    }


    public function active_members(){

        $active_members = Member_user::where('status', 1)->get();

        $all_directors = Admin_user::where('role_id', 2)->where('status', 1)->get();
        $all_seos = Admin_user::where('role_id', 4)->where('status', 1)->get();
        $all_eos = Admin_user::where('role_id', 5)->where('status', 1)->get();
        $all_executives = Admin_user::where('role_id', 6)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();

        $roles = User_role::all();

        $all_admins = Admin_user::all();

        $all_members = Member_user::all();

        return view('admin_view.common.active_members', compact('active_members', 'all_directors', 'all_seos', 'all_eos', 'all_executives', 'all_cps', 'all_presenters', 'roles', 'all_admins', 'all_members'));
    }
    

    
    public function inactive_members(){

        $inactive_members = Member_user::where('dg_approval', 1)->where('director_approval', 1)->where('status', 0)->get();

        $all_directors = Admin_user::where('role_id', 2)->where('status', 1)->get();
        $all_seos = Admin_user::where('role_id', 4)->where('status', 1)->get();
        $all_eos = Admin_user::where('role_id', 5)->where('status', 1)->get();
        $all_executives = Admin_user::where('role_id', 6)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();

        $roles = User_role::all();

        $all_admins = Admin_user::all();

        $all_members = Member_user::all();

        return view('admin_view.common.inactive_members', compact('inactive_members', 'all_directors', 'all_seos', 'all_eos', 'all_executives', 'all_cps', 'all_presenters', 'roles', 'all_admins', 'all_members'));
    }
    

    public function inactive_members_update(Request $request){

        $inactive_members_update = Member_user::find($request->member_id);

        if(!empty($request->director_id) && $inactive_members_update->director_id != $request->director_id){
            $inactive_members_update->director_id = $request->director_id;
        }

        if(!empty($request->seo_id) && $inactive_members_update->seo_id != $request->seo_id){
            $inactive_members_update->seo_id = $request->seo_id;
        }

        if(!empty($request->eo_id) && $inactive_members_update->eo_id != $request->eo_id){
            $inactive_members_update->eo_id = $request->eo_id;
        }

        if(!empty($request->executive_id) && $inactive_members_update->executive_id != $request->executive_id){
            $inactive_members_update->executive_id = $request->executive_id;
        }

        if(!empty($request->cp_id) && $inactive_members_update->cp_id != $request->cp_id){
            $inactive_members_update->cp_id = $request->cp_id;
        }

        if(!empty($request->presenter_id) && $inactive_members_update->presenter_id != $request->presenter_id){
            $inactive_members_update->presenter_id = $request->presenter_id;
        }

        if($request->status == 1){
            $inactive_members_update->status = $request->status;
                
        }

        $inactive_members_update->update();

        if($request->status == 1){
                
            $subject_member = 'Account activation.';

                
            $body_member = '
            Hello Sir, <br><br>
            Your account has been activated. <br> <br>
            Check your dashboard. <br>
            Thank you, <br>
            Effort E-learning MP.
            ';

            

            Mail::to($inactive_members_update->email)->send(new SendMail($subject_member, $body_member));
            
        }


        return back()->with('success', 'Request submitted..!');
    }
    

    public function active_members_update(Request $request){

        $active_members_update = Member_user::find($request->member_id);

        if(!empty($request->director_id) && $active_members_update->director_id != $request->director_id){
            $active_members_update->director_id = $request->director_id;
        }

        if(!empty($request->seo_id) && $active_members_update->director_id != $request->director_id){
            $active_members_update->seo_id = $request->seo_id;
        }

        if(!empty($request->eo_id) && $active_members_update->eo_id != $request->eo_id){
            $active_members_update->eo_id = $request->eo_id;
        }

        if(!empty($request->executive_id) && $active_members_update->executive_id != $request->executive_id){
            $active_members_update->executive_id = $request->executive_id;
        }

        if(!empty($request->cp_id) && $active_members_update->cp_id != $request->cp_id){
            $active_members_update->cp_id = $request->cp_id;
        }

        if(!empty($request->presenter_id) && $active_members_update->presenter_id != $request->presenter_id){
            $active_members_update->presenter_id = $request->presenter_id;
        }

        if($request->status == 0){
            $active_members_update->status = $request->status;
        }

        $active_members_update->update();

        if($request->status == 0){
                
            $subject_member = 'Account deactivation.';

                
            $body_member = '
            Hello Sir, <br><br>
            Your request has been deactivated. <br> <br>
            If you think we are wrong then contact us. <br>
            Thank you, <br>
            Effort E-learning MP.
            ';

            Mail::to($active_members_update->email)->send(new SendMail($subject_member, $body_member));
            
        }


        return back()->with('success', 'Request submitted..!');
    }
    
    public function join_requests(){

        $join_requests = Member_user::where('cp_id', null)->where('presenter_id', null)->where('cp_approval', 0)->where('presenter_approval', 0)->where('status', 0)->get();

        $all_directors = Admin_user::where('role_id', 2)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();

        $roles = User_role::all();

        $all_admins = Admin_user::all();

        $all_members = Member_user::all();

        return view('admin_view.common.join_requests', compact('join_requests', 'all_directors', 'all_cps', 'all_presenters', 'roles', 'all_admins', 'all_members'));
    }
    
    public function join_request_update(Request $request){

        $join_request_update = Member_user::find($request->member_id);

        if(!empty($request->cp_id)){
            $join_request_update->cp_id = $request->cp_id;

            $cp_select = Admin_user::find($request->cp_id);

            $subject = 'New member review.';

                
            $body = '
            Hello Sir, <br><br>
            A new member is waiting for review. <br> <br>
            Check your dashboard. <br>
            Thank you, <br>
            Effort E-learning MP.
            ';

            Mail::to($cp_select->email)->send(new SendMail($subject, $body));
            
        }

        if(!empty($request->presenter_id)){
            $join_request_update->presenter_id = $request->presenter_id;
            
            $presenter_select = Admin_user::find($request->presenter_id);

            $subject = 'Request Aprroval.';

                
            $body = '
            Hello Sir, <br><br>
            Your request has been approved. <br> <br>
            Check your dashboard. <br>
            Thank you, <br>
            Effort E-learning MP.
            ';

            Mail::to($presenter_select->email)->send(new SendMail($subject, $body));
        }

        if(!empty($request->status) && $request->status == 1){
            
            $dg = Admin_user::where('email', '!=', 'pritomguha62@gmail.com')->where('email', '!=', 'holy.it01@gmail.com')->where('role_id', 1)->first();
            
            $join_request_update->dg_id = $dg->admin_id;
            $join_request_update->dg_approval = 1;
            $join_request_update->director_approval = 1;
            $parent_user_member = Member_user::where('user_code', $join_request_update->parent_user_code)->first();
            $parent_user_admin = Admin_user::where('user_code', $join_request_update->parent_user_code)->first();

            $total_balance = 600;

            $member_profit = ($total_balance/100)*20;
            // $member_profit = 0;
            $presenter_profit = ($total_balance/100)*5;
            $cp_profit = ($total_balance/100)*7.5;
            $executive_profit = ($total_balance/100)*5;
            $eo_profit = ($total_balance/100)*7.5;
            $seo_profit = ($total_balance/100)*2.5;
            $director_profit = ($total_balance/100)*8;

            if (!empty($parent_user_member->user_code)) {

                $parent_member_refered = Member_user::where('parent_user_code', $parent_user_member->user_code)->get()->count();

                $parent_member_active = Member_user::where('parent_user_code', $parent_user_member->user_code)->where('status', 1)->get()->count();

                // if (20*$parent_member_active >= $parent_member_refered) {
                //     $member_profit = $parent_member_refered;
                // }elseif (20*$parent_member_active < $parent_member_refered) {
                //     $member_profit = 20*$parent_member_active;
                // }

                $parent_user_member->balance = intval($parent_user_member->balance)+intval(round($member_profit));

                $parent_user_passbook = new Passbook();

                $parent_user_passbook->sender_name = 'Admin';
                $parent_user_passbook->receiver_name = $parent_user_member->name;
                $parent_user_passbook->sender_admin_id = session()->get('admin_id');
                $parent_user_passbook->receiver_member_id = $parent_user_member->member_id;
                $parent_user_passbook->amount = intval(round($member_profit));
                $parent_user_passbook->sender_user_code = session()->get('user_code');
                $parent_user_passbook->receiver_user_code = $parent_user_member->user_code;
                
                $parent_user_passbook->save();


                $presenter_member = Admin_user::where('admin_id', $parent_user_member->presenter_id)->where('status', 1)->first();

                $cp_member = Admin_user::where('admin_id', $parent_user_member->cp_id)->where('status', 1)->first();
                
                $executive_member = Admin_user::where('admin_id', $parent_user_member->executive_id)->where('status', 1)->first();
                
                $eo_member = Admin_user::where('admin_id', $parent_user_member->eo_id)->where('status', 1)->first();

                $seo_member = Admin_user::where('admin_id', $parent_user_member->seo_id)->where('status', 1)->first();


                if (!empty($presenter_member)) {
                    $presenter_member->balance =intval($presenter_member->balance)+intval(round($presenter_profit));
                    
                    $presenter_passbook = new Passbook();

                    $presenter_passbook->sender_name = 'Admin';
                    $presenter_passbook->receiver_name = $presenter_member->name;
                    $presenter_passbook->sender_admin_id = session()->get('admin_id');
                    $presenter_passbook->receiver_admin_id = $presenter_member->admin_id;
                    $presenter_passbook->amount = intval(round($presenter_profit));
                    $presenter_passbook->sender_user_code = session()->get('user_code');
                    $presenter_passbook->receiver_user_code = $presenter_member->user_code;
                    
                    $presenter_passbook->save();

                    $presenter_member->update();

                }else{
                    $presenter_profit = 0;
                }
                
                if (!empty($cp_member)) {

                    $cp_member->balance =intval($cp_member->balance)+intval(round($cp_profit));

                    $cp_passbook = new Passbook();

                    $cp_passbook->sender_name = 'Admin';
                    $cp_passbook->receiver_name = $cp_member->name;
                    $cp_passbook->sender_admin_id = session()->get('admin_id');
                    $cp_passbook->receiver_admin_id = $cp_member->admin_id;
                    $cp_passbook->amount = intval(round($cp_profit));
                    $cp_passbook->sender_user_code = session()->get('user_code');
                    $cp_passbook->receiver_user_code = $cp_member->user_code;

                    $cp_passbook->save();

                    $cp_member->update();

                }else{
                    $cp_profit = 0;
                }
                


                if (!empty($executive_member)) {
                    $executive_member->balance =intval($executive_member->balance)+intval(round($executive_profit));
                    
                    $executive_passbook = new Passbook();

                    $executive_passbook->sender_name = 'Admin';
                    $executive_passbook->receiver_name = $executive_member->name;
                    $executive_passbook->sender_admin_id = session()->get('admin_id');
                    $executive_passbook->receiver_admin_id = $executive_member->admin_id;
                    $executive_passbook->amount = intval(round($executive_profit));
                    $executive_passbook->sender_user_code = session()->get('user_code');
                    $executive_passbook->receiver_user_code = $executive_member->user_code;
                    
                    $executive_passbook->save();

                    $executive_member->update();

                }else{
                    $executive_profit = 0;
                }
                


                if (!empty($eo_member)) {
                    $eo_member->balance =intval($eo_member->balance)+intval(round($eo_profit));
                    
                    $eo_passbook = new Passbook();

                    $eo_passbook->sender_name = 'Admin';
                    $eo_passbook->receiver_name = $eo_member->name;
                    $eo_passbook->sender_admin_id = session()->get('admin_id');
                    $eo_passbook->receiver_admin_id = $eo_member->admin_id;
                    $eo_passbook->amount = intval(round($eo_profit));
                    $eo_passbook->sender_user_code = session()->get('user_code');
                    $eo_passbook->receiver_user_code = $eo_member->user_code;
                    
                    $eo_passbook->save();

                    $eo_member->update();

                }else{
                    $eo_profit = 0;
                }
                


                if (!empty($seo_member)) {

                    $seo_member->balance =intval($seo_member->balance)+intval(round($seo_profit));
                    
                    $seo_passbook = new Passbook();

                    $seo_passbook->sender_name = 'Admin';
                    $seo_passbook->receiver_name = $seo_member->name;
                    $seo_passbook->sender_admin_id = session()->get('admin_id');
                    $seo_passbook->receiver_admin_id = $seo_member->admin_id;
                    $seo_passbook->amount = intval(round($seo_profit));
                    $seo_passbook->sender_user_code = session()->get('user_code');
                    $seo_passbook->receiver_user_code = $seo_member->user_code;
                    
                    $seo_passbook->save();

                    $seo_member->update();

                }else{
                    $seo_profit = 0;
                }
                
                $parent_user_member->update();

                // $group_leader_info = Admin_user::where('user_code', $parent_user_member->group_leader_code)->where('status', 1)->first();

                // $this->admin_money_add($group_leader_info, $total_balance, $remaining_profit);

            }else{
                $presenter_profit = 0;
                $cp_profit = 0;
                $executive_profit = 0;
                $eo_profit = 0;
                $seo_profit = 0;
                $director_profit_total = 0;
                $parent_user_admin_profit = 0;
                $parent_user_member = 0;
            }
            
            if (!empty($parent_user_admin)) {

                // $remaining_profit = $total_balance;
                // $this->admin_money_add($parent_user_admin, $total_balance, $remaining_profit);

                $parent_user_admin_profit = ($total_balance/100)*20;
                
                $parent_user_admin->balance =intval($parent_user_admin->balance)+intval(round($parent_user_admin_profit));
                    
                $parent_user_admin_passbook = new Passbook();

                $parent_user_admin_passbook->sender_name = 'Admin';
                $parent_user_admin_passbook->receiver_name = $parent_user_admin->name;
                $parent_user_admin_passbook->sender_admin_id = session()->get('admin_id');
                $parent_user_admin_passbook->receiver_admin_id = $parent_user_admin->admin_id;
                $parent_user_admin_passbook->amount = intval(round($parent_user_admin_profit));
                $parent_user_admin_passbook->sender_user_code = session()->get('user_code');
                $parent_user_admin_passbook->receiver_user_code = $parent_user_admin->user_code;
                
                $parent_user_admin_passbook->save();

                $parent_user_admin->update();


            }else{
                $parent_user_admin_profit = 0;
            }
            
            $directors_member = Admin_user::where('role_id', 2)->where('status', 1)->get();

            if (!empty($directors_member)) {

                        
                $director_profit_total = 0;

                foreach ($directors_member as $director_member) {
                    
                    $director_member->balance =intval($director_member->balance)+intval(round($director_profit));


                    $director_profit_total = intval($director_profit_total)+intval(round($director_profit));
                    
                    $director_passbook = new Passbook();

                    $director_passbook->sender_name = 'Admin';
                    $director_passbook->receiver_name = $director_member->name;
                    $director_passbook->sender_admin_id = session()->get('admin_id');
                    $director_passbook->receiver_admin_id = $director_member->admin_id;
                    $director_passbook->amount = intval(round($director_profit));
                    $director_passbook->sender_user_code = session()->get('user_code');
                    $director_passbook->receiver_user_code = $director_member->user_code;
                    
                    $director_passbook->save();

                    $director_member->update();


                }


            }else{
                $director_profit = 0;
            }
            

            $diff = intval(round($member_profit))+intval(round($presenter_profit))+intval(round($cp_profit))+intval(round($executive_profit))+intval(round($eo_profit))+intval(round($seo_profit))+intval(round($director_profit_total))+intval(round($parent_user_admin_profit));

            $remaining_profit = intval($total_balance)-round($diff);



            $dg_member = Admin_user::where('email', '!=', 'pritomguha62@gmail.com')->where('email', '!=', 'holy.it01@gmail.com')->where('role_id', 1)->first();

            
            $dg_member->balance =intval($dg_member->balance)+intval(round($remaining_profit));
                    
            $dg_passbook = new Passbook();

            $dg_passbook->sender_name = 'Admin';
            $dg_passbook->receiver_name = $dg_member->name;
            $dg_passbook->sender_admin_id = session()->get('admin_id');
            $dg_passbook->receiver_admin_id = $dg_member->admin_id;
            $dg_passbook->amount = intval(round($remaining_profit));
            $dg_passbook->sender_user_code = session()->get('user_code');
            $dg_passbook->receiver_user_code = $dg_member->user_code;
            
            $dg_passbook->save();

            $dg_member->update();


            $join_request_update->status = $request->status;
                
            $subject_member = 'Request Approval.';

                
            $body_member = '
            Hello Sir, <br><br>
            Your request has been approved. <br> <br>
            Check your dashboard. <br>
            Thank you, <br>
            Effort E-learning MP.
            ';

            Mail::to($join_request_update->email)->send(new SendMail($subject_member, $body_member));
            
        }

        $join_request_update->update();


        return back()->with('success', 'Request approved..!');
    }
    
    
    public function dg_approvals(){

        $dg_approvals = Member_user::where('dg_approval', 0)->where('director_approval', 0)->where('cp_approval', 1)->orWhere('presenter_approval', 1)->where('status', 0)->get();

        $all_directors = Admin_user::where('role_id', 2)->where('status', 1)->get();
        $all_seos = Admin_user::where('role_id', 4)->where('status', 1)->get();
        $all_eos = Admin_user::where('role_id', 5)->where('status', 1)->get();
        $all_executives = Admin_user::where('role_id', 6)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();

        $roles = User_role::all();

        $all_admins = Admin_user::all();

        $all_members = Member_user::all();

        return view('admin_view.common.dg_approvals', compact('dg_approvals', 'all_directors', 'all_seos', 'all_eos', 'all_executives', 'all_cps', 'all_presenters', 'roles', 'all_admins', 'all_members'));
    }
    

    public function dg_approval_update(Request $request){

        $dg_approval_update = Member_user::find($request->member_id);

        $dg = Admin_user::where('email', '!=', 'pritomguha62@gmail.com')->where('email', '!=', 'holy.it01@gmail.com')->where('role_id', 1)->first();
        
        $dg_approval_update->dg_id = $dg->admin_id;
        $dg_approval_update->dg_approval = 1;
        $dg_approval_update->director_approval = 1;
        $parent_user_member = Member_user::where('user_code', $dg_approval_update->parent_user_code)->first();
        $parent_user_admin = Admin_user::where('user_code', $dg_approval_update->parent_user_code)->first();

        $total_balance = 600;

        $member_profit = ($total_balance/100)*20;
        // $member_profit = 0;
        $presenter_profit = ($total_balance/100)*5;
        $cp_profit = ($total_balance/100)*7.5;
        $executive_profit = ($total_balance/100)*5;
        $eo_profit = ($total_balance/100)*7.5;
        $seo_profit = ($total_balance/100)*2.5;
        $director_profit = ($total_balance/100)*8;

        if (!empty($parent_user_member)) {

            $parent_member_refered = Member_user::where('parent_user_code', $parent_user_member->user_code)->get()->count();

            $parent_member_active = Member_user::where('parent_user_code', $parent_user_member->user_code)->get()->count();

            // if (20*$parent_member_active >= $parent_member_refered) {
            //     $member_profit = $parent_member_refered;
            // }elseif (20*$parent_member_active < $parent_member_refered) {
            //     $member_profit = 20*$parent_member_active;
            // }

            $parent_user_member->balance = intval($parent_user_member->balance)+intval(round($member_profit));

            $parent_user_passbook = new Passbook();

            $parent_user_passbook->sender_name = 'Admin';
            $parent_user_passbook->receiver_name = $parent_user_member->name;
            $parent_user_passbook->sender_admin_id = session()->get('admin_id');
            $parent_user_passbook->receiver_member_id = $parent_user_member->member_id;
            $parent_user_passbook->amount = intval(round($member_profit));
            $parent_user_passbook->sender_user_code = session()->get('user_code');
            $parent_user_passbook->receiver_user_code = $parent_user_member->user_code;
            
            $parent_user_passbook->save();


            $presenter_member = Admin_user::where('admin_id', $parent_user_member->presenter_id)->where('status', 1)->first();

            $cp_member = Admin_user::where('admin_id', $parent_user_member->cp_id)->where('status', 1)->first();
            
            $executive_member = Admin_user::where('admin_id', $parent_user_member->executive_id)->where('status', 1)->first();
            
            $eo_member = Admin_user::where('admin_id', $parent_user_member->eo_id)->where('status', 1)->first();

            $seo_member = Admin_user::where('admin_id', $parent_user_member->seo_id)->where('status', 1)->first();


            if (!empty($presenter_member)) {
                $presenter_member->balance =intval($presenter_member->balance)+intval(round($presenter_profit));
                
                $presenter_passbook = new Passbook();

                $presenter_passbook->sender_name = 'Admin';
                $presenter_passbook->receiver_name = $presenter_member->name;
                $presenter_passbook->sender_admin_id = session()->get('admin_id');
                $presenter_passbook->receiver_admin_id = $presenter_member->admin_id;
                $presenter_passbook->amount = intval(round($presenter_profit));
                $presenter_passbook->sender_user_code = session()->get('user_code');
                $presenter_passbook->receiver_user_code = $presenter_member->user_code;
                
                $presenter_passbook->save();

                $presenter_member->update();

            }else{
                $presenter_profit = 0;
            }
            
            if (!empty($cp_member)) {

                $cp_member->balance =intval($cp_member->balance)+intval(round($cp_profit));

                $cp_passbook = new Passbook();

                $cp_passbook->sender_name = 'Admin';
                $cp_passbook->receiver_name = $cp_member->name;
                $cp_passbook->sender_admin_id = session()->get('admin_id');
                $cp_passbook->receiver_admin_id = $cp_member->admin_id;
                $cp_passbook->amount = intval(round($cp_profit));
                $cp_passbook->sender_user_code = session()->get('user_code');
                $cp_passbook->receiver_user_code = $cp_member->user_code;

                $cp_passbook->save();

                $cp_member->update();

            }else{
                $cp_profit = 0;
            }
            


            if (!empty($executive_member)) {
                $executive_member->balance =intval($executive_member->balance)+intval(round($executive_profit));
                
                $executive_passbook = new Passbook();

                $executive_passbook->sender_name = 'Admin';
                $executive_passbook->receiver_name = $executive_member->name;
                $executive_passbook->sender_admin_id = session()->get('admin_id');
                $executive_passbook->receiver_admin_id = $executive_member->admin_id;
                $executive_passbook->amount = intval(round($executive_profit));
                $executive_passbook->sender_user_code = session()->get('user_code');
                $executive_passbook->receiver_user_code = $executive_member->user_code;
                
                $executive_passbook->save();

                $executive_member->update();

            }else{
                $executive_profit = 0;
            }
            


            if (!empty($eo_member)) {
                $eo_member->balance =intval($eo_member->balance)+intval(round($eo_profit));
                
                $eo_passbook = new Passbook();

                $eo_passbook->sender_name = 'Admin';
                $eo_passbook->receiver_name = $eo_member->name;
                $eo_passbook->sender_admin_id = session()->get('admin_id');
                $eo_passbook->receiver_admin_id = $eo_member->admin_id;
                $eo_passbook->amount = intval(round($eo_profit));
                $eo_passbook->sender_user_code = session()->get('user_code');
                $eo_passbook->receiver_user_code = $eo_member->user_code;
                
                $eo_passbook->save();

                $eo_member->update();

            }else{
                $eo_profit = 0;
            }
            


            if (!empty($seo_member)) {

                $seo_member->balance =intval($seo_member->balance)+intval(round($seo_profit));
                
                $seo_passbook = new Passbook();

                $seo_passbook->sender_name = 'Admin';
                $seo_passbook->receiver_name = $seo_member->name;
                $seo_passbook->sender_admin_id = session()->get('admin_id');
                $seo_passbook->receiver_admin_id = $seo_member->admin_id;
                $seo_passbook->amount = intval(round($seo_profit));
                $seo_passbook->sender_user_code = session()->get('user_code');
                $seo_passbook->receiver_user_code = $seo_member->user_code;
                
                $seo_passbook->save();

                $seo_member->update();

            }else{
                $seo_profit = 0;
            }
            
            $parent_user_member->update();

            // $group_leader_info = Admin_user::where('user_code', $parent_user_member->group_leader_code)->where('status', 1)->first();

            // $this->admin_money_add($group_leader_info, $total_balance, $remaining_profit);

        }else{
                $presenter_profit = 0;
                $cp_profit = 0;
                $executive_profit = 0;
                $eo_profit = 0;
                $seo_profit = 0;
                $director_profit_total = 0;
                $parent_user_admin_profit = 0;
                $parent_user_member = 0;
            }
        
        if (!empty($parent_user_admin)) {

            // $remaining_profit = $total_balance;
            // $this->admin_money_add($parent_user_admin, $total_balance, $remaining_profit);

            $parent_user_admin_profit = ($total_balance/100)*20;
            
            $parent_user_admin->balance =intval($parent_user_admin->balance)+intval(round($parent_user_admin_profit));
                
            $parent_user_admin_passbook = new Passbook();

            $parent_user_admin_passbook->sender_name = 'Admin';
            $parent_user_admin_passbook->receiver_name = $parent_user_admin->name;
            $parent_user_admin_passbook->sender_admin_id = session()->get('admin_id');
            $parent_user_admin_passbook->receiver_admin_id = $parent_user_admin->admin_id;
            $parent_user_admin_passbook->amount = intval(round($parent_user_admin_profit));
            $parent_user_admin_passbook->sender_user_code = session()->get('user_code');
            $parent_user_admin_passbook->receiver_user_code = $parent_user_admin->user_code;
            
            $parent_user_admin_passbook->save();

            $parent_user_admin->update();


        }else{
            $parent_user_admin_profit = 0;
        }
        
        $directors_member = Admin_user::where('role_id', 2)->where('status', 1)->get();

        if (!empty($directors_member)) {

            $director_profit_total = 0;
            
            foreach ($directors_member as $director_member) {
                
                $director_member->balance =intval($director_member->balance)+intval(round($director_profit));


                $director_profit_total = intval($director_profit_total)+intval(round($director_profit));
                
                $director_passbook = new Passbook();

                $director_passbook->sender_name = 'Admin';
                $director_passbook->receiver_name = $director_member->name;
                $director_passbook->sender_admin_id = session()->get('admin_id');
                $director_passbook->receiver_admin_id = $director_member->admin_id;
                $director_passbook->amount = intval(round($director_profit));
                $director_passbook->sender_user_code = session()->get('user_code');
                $director_passbook->receiver_user_code = $director_member->user_code;
                
                $director_passbook->save();

                $director_member->update();


            }


        }else{
            $director_profit = 0;
        }
        

        $diff = intval(round($member_profit))+intval(round($presenter_profit))+intval(round($cp_profit))+intval(round($executive_profit))+intval(round($eo_profit))+intval(round($seo_profit))+intval(round($director_profit_total))+intval(round($parent_user_admin_profit));

        $remaining_profit = intval($total_balance)-round($diff);



        $dg_member = Admin_user::where('email', '!=', 'pritomguha62@gmail.com')->where('email', '!=', 'holy.it01@gmail.com')->where('role_id', 1)->first();

        
        $dg_member->balance =intval($dg_member->balance)+intval(round($remaining_profit));
                
        $dg_passbook = new Passbook();

        $dg_passbook->sender_name = 'Admin';
        $dg_passbook->receiver_name = $dg_member->name;
        $dg_passbook->sender_admin_id = session()->get('admin_id');
        $dg_passbook->receiver_admin_id = $dg_member->admin_id;
        $dg_passbook->amount = intval(round($remaining_profit));
        $dg_passbook->sender_user_code = session()->get('user_code');
        $dg_passbook->receiver_user_code = $dg_member->user_code;
        
        $dg_passbook->save();

        $dg_member->update();


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
                
            $subject_member = 'Request Approval.';

                
            $body_member = '
            Hello Sir, <br><br>
            Your request has been approved. <br> <br>
            Check your dashboard. <br>
            Thank you, <br>
            Effort E-learning MP.
            ';

            // Mail::to($dg_approval_update->email)->send(new SendMail($subject_member, $body_member));
            
        }

        $dg_approval_update->update();


        return back()->with('success', 'Request approved..!');
    }
    

    public function director_approvals(){

        $director_approvals = Member_user::where('dg_approval', 0)->where('director_approval', 0)->where('cp_approval', 1)->orWhere('presenter_approval', 1)->where('status', 0)->get();

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

        $dg = Admin_user::where('email', '!=', 'pritomguha62@gmail.com')->where('email', '!=', 'holy.it01@gmail.com')->where('role_id', 1)->first();
        
        $director_approval_update->dg_id = $dg->admin_id;

        $director_approval_update->director_id = session()->get('admin_id');
        $director_approval_update->dg_approval = 1;
        $director_approval_update->director_approval = 1;
            
        $parent_user_member = Member_user::where('user_code', $director_approval_update->parent_user_code)->first();
        $parent_user_admin = Admin_user::where('user_code', $director_approval_update->parent_user_code)->first();

        $total_balance = 600;

        $member_profit = ($total_balance/100)*20;
        // $member_profit = 0;
        $presenter_profit = ($total_balance/100)*5;
        $cp_profit = ($total_balance/100)*7.5;
        $executive_profit = ($total_balance/100)*5;
        $eo_profit = ($total_balance/100)*7.5;
        $seo_profit = ($total_balance/100)*2.5;
        $director_profit = ($total_balance/100)*8;

        if (!empty($parent_user_member)) {

            $parent_member_refered = Member_user::where('parent_user_code', $parent_user_member->user_code)->get()->count();

            $parent_member_active = Member_user::where('parent_user_code', $parent_user_member->user_code)->where('status', 1)->get()->count();

            // if (20*$parent_member_active >= $parent_member_refered) {
            //     $member_profit = $parent_member_refered;
            // }elseif (20*$parent_member_active < $parent_member_refered) {
            //     $member_profit = 20*$parent_member_active;
            // }

            $parent_user_member->balance = intval($parent_user_member->balance)+intval(round($member_profit));

            $parent_user_passbook = new Passbook();

            $parent_user_passbook->sender_name = 'Admin';
            $parent_user_passbook->receiver_name = $parent_user_member->name;
            $parent_user_passbook->sender_admin_id = session()->get('admin_id');
            $parent_user_passbook->receiver_member_id = $parent_user_member->member_id;
            $parent_user_passbook->amount = intval(round($member_profit));
            $parent_user_passbook->sender_user_code = session()->get('user_code');
            $parent_user_passbook->receiver_user_code = $parent_user_member->user_code;
            
            $parent_user_passbook->save();


            $presenter_member = Admin_user::where('admin_id', $parent_user_member->presenter_id)->where('status', 1)->first();

            $cp_member = Admin_user::where('admin_id', $parent_user_member->cp_id)->where('status', 1)->first();
            
            $executive_member = Admin_user::where('admin_id', $parent_user_member->executive_id)->where('status', 1)->first();
            
            $eo_member = Admin_user::where('admin_id', $parent_user_member->eo_id)->where('status', 1)->first();

            $seo_member = Admin_user::where('admin_id', $parent_user_member->seo_id)->where('status', 1)->first();


            if (!empty($presenter_member)) {
                $presenter_member->balance =intval($presenter_member->balance)+intval(round($presenter_profit));
                
                $presenter_passbook = new Passbook();

                $presenter_passbook->sender_name = 'Admin';
                $presenter_passbook->receiver_name = $presenter_member->name;
                $presenter_passbook->sender_admin_id = session()->get('admin_id');
                $presenter_passbook->receiver_admin_id = $presenter_member->admin_id;
                $presenter_passbook->amount = intval(round($presenter_profit));
                $presenter_passbook->sender_user_code = session()->get('user_code');
                $presenter_passbook->receiver_user_code = $presenter_member->user_code;
                
                $presenter_passbook->save();

                $presenter_member->update();

            }else{
                $presenter_profit = 0;
            }
            
            if (!empty($cp_member)) {

                $cp_member->balance =intval($cp_member->balance)+intval(round($cp_profit));

                $cp_passbook = new Passbook();

                $cp_passbook->sender_name = 'Admin';
                $cp_passbook->receiver_name = $cp_member->name;
                $cp_passbook->sender_admin_id = session()->get('admin_id');
                $cp_passbook->receiver_admin_id = $cp_member->admin_id;
                $cp_passbook->amount = intval(round($cp_profit));
                $cp_passbook->sender_user_code = session()->get('user_code');
                $cp_passbook->receiver_user_code = $cp_member->user_code;

                $cp_passbook->save();

                $cp_member->update();

            }else{
                $cp_profit = 0;
            }
            


            if (!empty($executive_member)) {
                $executive_member->balance =intval($executive_member->balance)+intval(round($executive_profit));
                
                $executive_passbook = new Passbook();

                $executive_passbook->sender_name = 'Admin';
                $executive_passbook->receiver_name = $executive_member->name;
                $executive_passbook->sender_admin_id = session()->get('admin_id');
                $executive_passbook->receiver_admin_id = $executive_member->admin_id;
                $executive_passbook->amount = intval(round($executive_profit));
                $executive_passbook->sender_user_code = session()->get('user_code');
                $executive_passbook->receiver_user_code = $executive_member->user_code;
                
                $executive_passbook->save();

                $executive_member->update();

            }else{
                $executive_profit = 0;
            }
            


            if (!empty($eo_member)) {
                $eo_member->balance =intval($eo_member->balance)+intval(round($eo_profit));
                
                $eo_passbook = new Passbook();

                $eo_passbook->sender_name = 'Admin';
                $eo_passbook->receiver_name = $eo_member->name;
                $eo_passbook->sender_admin_id = session()->get('admin_id');
                $eo_passbook->receiver_admin_id = $eo_member->admin_id;
                $eo_passbook->amount = intval(round($eo_profit));
                $eo_passbook->sender_user_code = session()->get('user_code');
                $eo_passbook->receiver_user_code = $eo_member->user_code;
                
                $eo_passbook->save();

                $eo_member->update();

            }else{
                $eo_profit = 0;
            }
            


            if (!empty($seo_member)) {

                $seo_member->balance =intval($seo_member->balance)+intval(round($seo_profit));
                
                $seo_passbook = new Passbook();

                $seo_passbook->sender_name = 'Admin';
                $seo_passbook->receiver_name = $seo_member->name;
                $seo_passbook->sender_admin_id = session()->get('admin_id');
                $seo_passbook->receiver_admin_id = $seo_member->admin_id;
                $seo_passbook->amount = intval(round($seo_profit));
                $seo_passbook->sender_user_code = session()->get('user_code');
                $seo_passbook->receiver_user_code = $seo_member->user_code;
                
                $seo_passbook->save();

                $seo_member->update();

            }else{
                $seo_profit = 0;
            }
            
            $parent_user_member->update();

            // $group_leader_info = Admin_user::where('user_code', $parent_user_member->group_leader_code)->where('status', 1)->first();

            // $this->admin_money_add($group_leader_info, $total_balance, $remaining_profit);

        }else{
            $presenter_profit = 0;
            $cp_profit = 0;
            $executive_profit = 0;
            $eo_profit = 0;
            $seo_profit = 0;
            $director_profit_total = 0;
            $parent_user_admin_profit = 0;
            $parent_user_member = 0;
        }
        
        if (!empty($parent_user_admin)) {

            // $remaining_profit = $total_balance;
            // $this->admin_money_add($parent_user_admin, $total_balance, $remaining_profit);

            $parent_user_admin_profit = ($total_balance/100)*20;
            
            $parent_user_admin->balance =intval($parent_user_admin->balance)+intval(round($parent_user_admin_profit));
                
            $parent_user_admin_passbook = new Passbook();

            $parent_user_admin_passbook->sender_name = 'Admin';
            $parent_user_admin_passbook->receiver_name = $parent_user_admin->name;
            $parent_user_admin_passbook->sender_admin_id = session()->get('admin_id');
            $parent_user_admin_passbook->receiver_admin_id = $parent_user_admin->admin_id;
            $parent_user_admin_passbook->amount = intval(round($parent_user_admin_profit));
            $parent_user_admin_passbook->sender_user_code = session()->get('user_code');
            $parent_user_admin_passbook->receiver_user_code = $parent_user_admin->user_code;
            
            $parent_user_admin_passbook->save();

            $parent_user_admin->update();


        }else{
            $parent_user_admin_profit = 0;
        }
        
        $directors_member = Admin_user::where('role_id', 2)->where('status', 1)->get();

        if (!empty($directors_member)) {

            $director_profit_total = 0;
                        
            foreach ($directors_member as $director_member) {
                
                $director_member->balance =intval($director_member->balance)+intval(round($director_profit));


                $director_profit_total = intval($director_profit_total)+intval(round($director_profit));
                
                $director_passbook = new Passbook();

                $director_passbook->sender_name = 'Admin';
                $director_passbook->receiver_name = $director_member->name;
                $director_passbook->sender_admin_id = session()->get('admin_id');
                $director_passbook->receiver_admin_id = $director_member->admin_id;
                $director_passbook->amount = intval(round($director_profit));
                $director_passbook->sender_user_code = session()->get('user_code');
                $director_passbook->receiver_user_code = $director_member->user_code;
                
                $director_passbook->save();

                $director_member->update();


            }


        }else{
            $director_profit = 0;
        }
        

        $diff = intval(round($member_profit))+intval(round($presenter_profit))+intval(round($cp_profit))+intval(round($executive_profit))+intval(round($eo_profit))+intval(round($seo_profit))+intval(round($director_profit_total))+intval(round($parent_user_admin_profit));

        $remaining_profit = intval($total_balance)-round($diff);



        $dg_member = Admin_user::where('email', '!=', 'pritomguha62@gmail.com')->where('email', '!=', 'holy.it01@gmail.com')->where('role_id', 1)->first();

        
        $dg_member->balance =intval($dg_member->balance)+intval(round($remaining_profit));
                
        $dg_passbook = new Passbook();

        $dg_passbook->sender_name = 'Admin';
        $dg_passbook->receiver_name = $dg_member->name;
        $dg_passbook->sender_admin_id = session()->get('admin_id');
        $dg_passbook->receiver_admin_id = $dg_member->admin_id;
        $dg_passbook->amount = intval(round($remaining_profit));
        $dg_passbook->sender_user_code = session()->get('user_code');
        $dg_passbook->receiver_user_code = $dg_member->user_code;
        
        $dg_passbook->save();

        $dg_member->update();


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

        if(!empty($request->status) && $request->status == 1){
            $director_approval_update->status = $request->status;
            
            $subject_member = 'Request Approval.';

            $body_member = '
            Hello Sir, <br><br>
            Your request has been approved. <br> <br>
            Check your dashboard. <br>
            Thank you, <br>
            Effort E-learning MP.
            ';

            Mail::to($director_approval_update->email)->send(new SendMail($subject_member, $body_member));

        }

        $director_approval_update->update();


        return back()->with('success', 'Request approved..!');
    }
    

    public function seo_approvals(){

        $seo_approvals = Member_user::where('dg_approval', 1)->where('director_approval', 1)->where('seo_id', session()->get('admin_id'))->where('seo_approval', 0)->where('status', 1)->get();

        $all_directors = Admin_user::where('role_id', 2)->where('status', 1)->get();
        $all_seos = Admin_user::where('role_id', 4)->where('status', 1)->get();
        $all_eos = Admin_user::where('role_id', 5)->where('status', 1)->get();
        $all_executives = Admin_user::where('role_id', 6)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();

        $roles = User_role::all();

        $all_admins = Admin_user::all();

        $all_members = Member_user::all();

        return view('admin_view.common.seo_approvals', compact('seo_approvals', 'all_admins', 'all_members', 'all_directors', 'all_seos', 'all_eos', 'all_executives', 'all_cps', 'all_presenters'));
    }
    
    public function seo_approval_update(Request $request){

        $seo_approval_update = Member_user::find($request->member_id);

        $seo_approval_update->seo_id = session()->get('admin_id');
        $seo_approval_update->seo_approval = 1;
        

        if(!empty($request->eo_id)){
            $seo_approval_update->eo_id = $request->eo_id;
        }

        if(!empty($request->executive_id)){
            $seo_approval_update->executive_id = $request->executive_id;
        }

        if(!empty($request->cp_id)){
            $seo_approval_update->cp_id = $request->cp_id;
        }

        if(!empty($request->presenter_id)){
            $seo_approval_update->presenter_id = $request->presenter_id;
        }

        $seo_approval_update->update();


        return back()->with('success', 'Request submitted..!');
    }
    

    public function eo_approvals(){

        $eo_approvals = Member_user::where('dg_approval', 1)->where('director_approval', 1)->where('eo_id', session()->get('admin_id'))->where('eo_approval', 0)->where('status', 1)->get();

        $all_directors = Admin_user::where('role_id', 2)->where('status', 1)->get();
        $all_seos = Admin_user::where('role_id', 4)->where('status', 1)->get();
        $all_eos = Admin_user::where('role_id', 5)->where('status', 1)->get();
        $all_executives = Admin_user::where('role_id', 6)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();

        $roles = User_role::all();

        $all_admins = Admin_user::all();

        $all_members = Member_user::all();

        return view('admin_view.common.eo_approvals', compact('eo_approvals', 'all_admins', 'all_members', 'all_directors', 'all_seos', 'all_eos', 'all_executives', 'all_cps', 'all_presenters'));
    }
    
    public function eo_approval_update(Request $request){

        $eo_approval_update = Member_user::find($request->member_id);

        $eo_approval_update->eo_id = session()->get('admin_id');
        $eo_approval_update->eo_approval = 1;

        if(!empty($request->executive_id)){
            $eo_approval_update->executive_id = $request->executive_id;
        }

        if(!empty($request->cp_id)){
            $eo_approval_update->cp_id = $request->cp_id;
        }

        if(!empty($request->presenter_id)){
            $eo_approval_update->presenter_id = $request->presenter_id;
        }

        $eo_approval_update->update();


        return back()->with('success', 'Request submitted..!');
    }
    

    public function executive_approvals(){

        $executive_approvals = Member_user::where('dg_approval', 1)->where('director_approval', 1)->where('executive_id', session()->get('admin_id'))->where('executive_approval', 0)->where('status', 1)->get();

        $all_directors = Admin_user::where('role_id', 2)->where('status', 1)->get();
        $all_seos = Admin_user::where('role_id', 4)->where('status', 1)->get();
        $all_eos = Admin_user::where('role_id', 5)->where('status', 1)->get();
        $all_executives = Admin_user::where('role_id', 6)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();

        $roles = User_role::all();

        $all_admins = Admin_user::all();

        $all_members = Member_user::all();

        return view('admin_view.common.executive_approvals', compact('executive_approvals', 'all_admins', 'all_members', 'all_directors', 'all_seos', 'all_eos', 'all_executives', 'all_cps', 'all_presenters'));
    }
    
    public function executive_approval_update(Request $request){

        $executive_approval_update = Member_user::find($request->member_id);

        $executive_approval_update->executive_id = session()->get('admin_id');
        $executive_approval_update->executive_approval = 1;
        

        if(!empty($request->cp_id)){
            $executive_approval_update->cp_id = $request->cp_id;
        }

        if(!empty($request->presenter_id)){
            $executive_approval_update->presenter_id = $request->presenter_id;
        }

        $executive_approval_update->update();


        return back()->with('success', 'Request submitted..!');
    }
    

    public function pending_approvals(){

        $pending_approvals = Member_user::where('dg_approval', '!=', 1)->where('cp_approval', '!=', 1)->where('cp_id', '!=', null)->orWhere('presenter_id', '!=', null)->where('cp_approval', 0)->where('status', 0)->get();

        // $all_directors = Admin_user::where('role_id', 2)->where('status', 1)->get();
        // $all_seos = Admin_user::where('role_id', 4)->where('status', 1)->get();
        // $all_eos = Admin_user::where('role_id', 5)->where('status', 1)->get();
        // $all_executives = Admin_user::where('role_id', 6)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();

        $roles = User_role::all();

        $all_admins = Admin_user::all();

        $all_members = Member_user::all();

        return view('admin_view.common.pending_approvals', compact('pending_approvals', 'all_admins', 'all_members', 'all_cps', 'all_presenters'));
    }
    
    public function pending_approval_update(Request $request){

        $pending_approval_update = Member_user::find($request->member_id);

        if ($request->cp_approval == 1) {
            $pending_approval_update->cp_approval = $request->cp_approval;
        }elseif ($request->cp_approval == 0) {
            $pending_approval_update->cp_id = null;
        }


        if(!empty($request->presenter_id) && $request->presenter_id != $pending_approval_update->presenter_id){
            $pending_approval_update->presenter_id = $request->presenter_id;
        }

        if(!empty($request->cp_id) && $request->cp_id != $pending_approval_update->cp_id){
            $pending_approval_update->cp_id = $request->cp_id;
        }

        // echo $pending_approval_update->cp_approval;
        // exit;
        $pending_approval_update->update();


        return back()->with('success', 'Request submitted..!');
    }
    

    public function cp_approvals(){

        $cp_approvals = Member_user::where('cp_id', session()->get('admin_id'))->where('cp_approval', 0)->where('status', 0)->get();

        // $all_directors = Admin_user::where('role_id', 2)->where('status', 1)->get();
        // $all_seos = Admin_user::where('role_id', 4)->where('status', 1)->get();
        // $all_eos = Admin_user::where('role_id', 5)->where('status', 1)->get();
        // $all_executives = Admin_user::where('role_id', 6)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();

        $roles = User_role::all();

        $all_admins = Admin_user::all();

        $all_members = Member_user::all();

        return view('admin_view.common.cp_approvals', compact('cp_approvals', 'all_admins', 'all_members', 'all_cps', 'all_presenters'));
    }
    
    
    public function cp_approval_update(Request $request){

        $cp_approval_update = Member_user::find($request->member_id);

        
        if ($request->cp_approval == 1) {
            $cp_approval_update->cp_approval = 1;
        }else {
            $cp_approval_update->cp_id = null;
        }


        if(!empty($request->presenter_id) && $request->presenter_id != $cp_approval_update->presenter_id){
            $cp_approval_update->presenter_id = $request->presenter_id;
        }

        $cp_approval_update->update();


        return back()->with('success', 'Request submitted..!');
    }
    

    public function presenter_approvals(){

        $presenter_approvals = Member_user::where('presenter_id', session()->get('admin_id'))->where('presenter_approval', 0)->where('status', 0)->get();

        // $all_directors = Admin_user::where('role_id', 2)->where('status', 1)->get();
        // $all_seos = Admin_user::where('role_id', 4)->where('status', 1)->get();
        // $all_eos = Admin_user::where('role_id', 5)->where('status', 1)->get();
        // $all_executives = Admin_user::where('role_id', 6)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();

        $roles = User_role::all();

        $all_admins = Admin_user::all();

        $all_members = Member_user::all();

        return view('admin_view.common.presenter_approvals', compact('presenter_approvals', 'all_admins', 'all_members', 'all_cps', 'all_presenters'));
    }
    
    public function presenter_approval_update(Request $request){

        $presenter_approval_update = Member_user::find($request->member_id);

        if ($request->presenter_approval == 1) {
            $presenter_approval_update->presenter_approval = 1;
        }else {
            $presenter_approval_update->presenter_id = null;
        }

        $presenter_approval_update->update();


        return back()->with('success', 'Request submitted..!');
    }

    public function member_references(){

        $member_references = Member_user::where('parent_user_code', session()->get('user_code'))->get();

        $member_inactive_references = Member_user::where('parent_user_code', session()->get('user_code'))->where('status', 0)->get();

        $member_active_references = Member_user::where('parent_user_code', session()->get('user_code'))->where('status', 1)->get();

        return view('member_view.member_references', compact('member_references', 'member_inactive_references', 'member_active_references'));

    }

    public function member_password(){
        return view('member_view.member_password');
    }

    public function member_password_change(Request $request){
        
        $request->validate(
            [
            "password"=> "required|min:8|max:16",
            "new_password"=> "required|min:8|max:16",
            "confirm_new_password"=> "required|same:new_password",
        ]);

        
        $member_user = Member_user::where('email', session()->get('email'))->first();

        if (!empty($member_user) && Hash::check($request->password, $member_user->password)) {
            $member_user->password = Hash::make($request->new_password);
            $member_user->update();

            $subject_member = 'Password Changed.';

            $body_member = '
            Hello, <br><br>
            Your password has been changed. If it was not you, please contact us. <br> <br>
            Thank you, <br>
            Effort E-learning MP.
            ';

            Mail::to($member_user->email)->send(new SendMail($subject_member, $body_member));
            
            return redirect()->back()->with('success', 'Password Changed..!');
        }else{
            return redirect()->back()->with('error', 'Password Can Not Be Changed..!');
        }

    }

    public function all_members(){

        $all_members = Member_user::all();

        $all_admins = Admin_user::all();

        $all_directors = Admin_user::where('role_id', 2)->where('status', 1)->get();
        $all_seos = Admin_user::where('role_id', 4)->where('status', 1)->get();
        $all_eos = Admin_user::where('role_id', 5)->where('status', 1)->get();
        $all_executives = Admin_user::where('role_id', 6)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();

        return view('admin_view.common.all_members', compact('all_members', 'all_admins', 'all_directors', 'all_seos', 'all_eos', 'all_executives', 'all_cps', 'all_presenters'));

    }
    

    public function update_all_members(Request $request){

        
        $update_all_members = Member_user::find($request->member_id);

        if (!empty($request->name) && $request->name !== $update_all_members->name) {
            $update_all_members->name = $request->name;
        }

        if (!empty($request->phone) && $request->phone !== $update_all_members->phone) {
            $update_all_members->phone = $request->phone;
        }

        if (!empty($request->email) && $request->email !== $update_all_members->email) {
            $update_all_members->email = $request->email;
        }

        if (!empty($request->whatsapp) && $request->whatsapp !== $update_all_members->whatsapp) {
            $update_all_members->whatsapp = $request->whatsapp;
        }

        if (!empty($request->home_town) && $request->home_town !== $update_all_members->home_town) {
            $update_all_members->home_town = $request->home_town;
        }

        if (!empty($request->city) && $request->city !== $update_all_members->city) {
            $update_all_members->city = $request->city;
        }

        if (!empty($request->country) && $request->country !== $update_all_members->country) {
            $update_all_members->country = $request->country;
        }

        // if (!empty($request->balance) && $request->balance !== $update_all_members->balance) {
        //     $update_all_members->balance = $request->balance;
        // }

        // if (!empty($request->withdraws) && $request->withdraws !== $update_all_members->withdraws) {
        //     $update_all_members->withdraws = $request->withdraws;
        // }

        // if(!empty($request->director_id) && $request->director_id !== $update_all_members->director_id){
        //     $update_all_members->director_id = $request->director_id;
        // }

        if(!empty($request->seo_id) && $request->seo_id !== $update_all_members->seo_id){
            $update_all_members->seo_id = $request->seo_id;
        }

        if(!empty($request->eo_id) && $request->eo_id !== $update_all_members->eo_id){
            $update_all_members->eo_id = $request->eo_id;
        }

        if(!empty($request->executive_id) && $request->executive_id !== $update_all_members->executive_id){
            $update_all_members->executive_id = $request->executive_id;
        }

        if(!empty($request->cp_id) && $request->cp_id !== $update_all_members->cp_id){
            $update_all_members->cp_id = $request->cp_id;
        }

        if(!empty($request->presenter_id) && $request->presenter_id !== $update_all_members->presenter_id){
            $update_all_members->presenter_id = $request->presenter_id;
        }

        if($request->status != $update_all_members->status){
            $update_all_members->status = $request->status;
        }

        $update_all_members->update();


        return back()->with('success', 'Information Updated..!');

    }
    
    
    public function refer_members(){

        $refer_members = Member_user::where('parent_user_code', session()->get('user_code'))->get();

        // $all_directors = Admin_user::where('role_id', 2)->where('status', 1)->get();
        // $all_seos = Admin_user::where('role_id', 4)->where('status', 1)->get();
        // $all_eos = Admin_user::where('role_id', 5)->where('status', 1)->get();
        // $all_executives = Admin_user::where('role_id', 6)->where('status', 1)->get();
        $all_cps = Admin_user::where('role_id', 7)->where('status', 1)->get();
        $all_presenters = Admin_user::where('role_id', 8)->where('status', 1)->get();

        $roles = User_role::all();

        $all_admins = Admin_user::all();

        $all_members = Member_user::all();

        return view('admin_view.common.refer_members', compact('refer_members', 'all_admins', 'all_members', 'all_cps', 'all_presenters'));
    }
    



















}




