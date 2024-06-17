<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Passbook;
use App\Models\Admin_user;
use App\Models\Withdrawal;
use App\Models\Member_user;
use Illuminate\Http\Request;
use App\Models\Payment_method;
use Illuminate\Support\Facades\Mail;

class WithdrawalController extends Controller
{
    
    public function member_payment_methods(){
        $member_payment_methods = Payment_method::where('member_id', session()->get('member_id'))->get();

        $all_members = Member_user::all();

        $member = Member_user::find(session()->get('member_id'));

        return view('member_view.withdrawal', compact('member_payment_methods', 'all_members', 'member'));
    }
    
    
    
    public function withdraw_request_member(Request $request){

        $request->validate([
            'method_id'=>'required',
            'amount'=>'required|numeric|min:100',
        ]);
        
        $payment_method = Payment_method::where('method_id', $request->method_id)->first();
        
        $member = Member_user::find(session()->get('member_id'));
        
        $dg = Admin_user::where('email', '!=', 'pritomguha62@gmail.com')->where('email', '!=', 'holy.it01@gmail.com')->where('role_id', 1)->first();
        
        $withdraw_request_member = new Withdrawal();

        if ($request->amount <= $member->balance) {

            $withdraw_request_member->name = session()->get('name');
            $withdraw_request_member->member_id = $payment_method->member_id;
            $withdraw_request_member->payment_method = $payment_method->name;
            $withdraw_request_member->account_num = $payment_method->account_num;
            $withdraw_request_member->user_code = session()->get('user_code');

            
            $request->amount = intval($request->amount);
            $member->balance = intval($member->balance);

            if ($member->withdraws == null) {
                if ($member->balance >= 300 && $request->amount >= 300) {
                    $member->balance = $member->balance - 200;
                    $amount = $request->amount - 200;
                    $dg->balance = intval($dg->balance) + 200;
                    $dg->update();
                    $request->amount = $amount;
                    
                }else {
                    return redirect()->back()->with('error', 'First withdraw amount must be 300 or more..!');
                }
            }


            $withdraw_request_member->amount = $request->amount;
            
            $member->withdraws = intval($member->withdraws);

            $new_balance = $member->balance - $request->amount;

            $new_withdraws = $member->withdraws + $request->amount;


            $member->balance = $new_balance;

            $member->withdraws = $new_withdraws;

            $withdraw_request_member->save();

            $member->update();
            
            $subject_member = 'Withdraw request.';

            $body_member = '
            Hello, <br><br>
            Your withdraw request has been sent. It may take some time for payment. <br> <br>
            Thank you, <br>
            Effort E-learning MP.
            ';

            Mail::to($member->email)->send(new SendMail($subject_member, $body_member));
            
            $subject_admin = 'Withdraw request.';

            $body_admin = '
            Hello, <br><br>
            A new withdraw request was created. Please check withdraw information for approval. <br> <br>
            Thank you, <br>
            Effort E-learning MP.
            ';

            Mail::to('mpeffortelearning@gmail.com')->send(new SendMail($subject_admin, $body_admin));

            return redirect()->back()->with('success', 'Withdraw Request Submited..!');

        }else{
            
            return redirect()->back()->with('error', 'Insufficient Balance..!');
        }


    }

    public function member_debit_passbook(Request $request){

        $member_debit_passbooks = Withdrawal::where('member_id', session()->get('member_id'))->get();

        return view('member_view.member_debit_passbook', compact('member_debit_passbooks'));

    }

    public function withdraw_approvals(Request $request){

        $withdraw_approvals = Withdrawal::where('status', 0)->where('approver_id', null)->get();

        return view('admin_view.common.withdraw_approvals', compact('withdraw_approvals'));

    }

    public function withdraw_approval_update(Request $request){

        $withdraw_approval_update = Withdrawal::find($request->withdrawal_id);
        $withdraw_member = Member_user::where('user_code', $withdraw_approval_update->user_code)->first();
        $withdraw_admin = Admin_user::where('user_code', $withdraw_approval_update->user_code)->first();

        if ($request->status == 1) {
            $withdraw_approval_update->status = 1;
            $withdraw_approval_update->approver_id = session()->get('admin_id');
            $withdraw_approval_update->approver_user_code = session()->get('user_code');
            if (!empty($withdraw_member->email)) {
                
                $subject_member = 'Withdraw request approved.';

                $body_member = '
                Hello, <br><br>
                Your withdraw request has been approved. It may take some time for payment. <br> <br>
                Thank you, <br>
                Effort E-learning MP.
                ';

                Mail::to($withdraw_member->email)->send(new SendMail($subject_member, $body_member));

            }elseif (!empty($withdraw_admin->email)) {
                
                $subject_admin = 'Withdraw request approved.';

                $body_admin = '
                Hello, <br><br>
                Your withdraw request has been approved. It may take some time for payment. <br> <br>
                Thank you, <br>
                Effort E-learning MP.
                ';

                Mail::to($withdraw_admin->email)->send(new SendMail($subject_admin, $body_admin));
            }
            
            $withdraw_approval_update->update();

            return redirect()->back()->with('success', 'Withdraw Request Approved..!');
        }elseif ($request->status == 0) {
            
            $withdraw_approval_update->status = 0;
            if (!empty($withdraw_member->member_id)) {
                $withdraw_member->balance = intval($withdraw_member->balance);
                $withdraw_member->balance = $withdraw_member->balance + intval($withdraw_approval_update->amount);

                $passbook = new Passbook();
                $passbook->sender_name = 'Withdraw Balance Return';
                $passbook->receiver_name = $withdraw_member->name;
                $passbook->sender_admin_id = session()->get('admin_id');
                $passbook->receiver_member_id = $withdraw_member->member_id;
                $passbook->amount = intval($withdraw_approval_update->amount);
                $passbook->receiver_user_code = $withdraw_member->user_code;
                $passbook->save();

                $withdraw_member->update();
                
                $subject_member = 'Withdraw request rejected.';

                $body_member = '
                Hello, <br><br>
                Your withdraw request has been rejected. Your balance was returned. <br> <br>
                Thank you, <br>
                Effort E-learning MP.
                ';

                Mail::to($withdraw_member->email)->send(new SendMail($subject_member, $body_member));

            }elseif (!empty($withdraw_admin->admin_id)) {
                $withdraw_admin->balance = intval($withdraw_admin->balance);
                $withdraw_admin->balance = $withdraw_admin->balance + intval($withdraw_approval_update->amount);

                $passbook = new Passbook();
                $passbook->sender_name = 'Withdraw Balance Return';
                $passbook->receiver_name = $withdraw_admin->name;
                $passbook->sender_admin_id = session()->get('admin_id');
                $passbook->receiver_admin_id = $withdraw_admin->admin_id;
                $passbook->amount = intval($withdraw_approval_update->amount);
                $passbook->receiver_user_code = $withdraw_admin->user_code;
                $passbook->save();
                
                $withdraw_admin->update();
                
                $subject_admin = 'Withdraw request rejected.';

                $body_admin = '
                Hello, <br><br>
                Your withdraw request has been rejected. Your balance was returned. <br> <br>
                Thank you, <br>
                Effort E-learning MP.
                ';

                Mail::to($withdraw_admin->email)->send(new SendMail($subject_admin, $body_admin));

            }
            
            $withdraw_approval_update->update();

            return redirect()->back()->with('error', 'Withdraw Request Rejected..!');
        }


    }


    public function admin_payment_methods(){
        $admin_payment_methods = Payment_method::where('admin_id', session()->get('admin_id'))->get();

        $all_admins = Admin_user::all();

        $admin = Admin_user::find(session()->get('admin_id'));

        return view('admin_view.common.withdrawal', compact('admin_payment_methods', 'all_admins', 'admin'));
    }
    

    public function withdraw_request_admin(Request $request){

        $request->validate([
            'method_id'=>'required',
            'amount'=>'required|numeric|min:100',
        ]);
        
        $payment_method = Payment_method::where('method_id', $request->method_id)->first();
        
        $admin = Admin_user::find(session()->get('admin_id'));
        
        $withdraw_request_admin = new Withdrawal();

        if ($request->amount <= $admin->balance) {

            $withdraw_request_admin->name = session()->get('name');
            $withdraw_request_admin->admin_id = $payment_method->admin_id;
            $withdraw_request_admin->payment_method = $payment_method->name;
            $withdraw_request_admin->account_num = $payment_method->account_num;
            $withdraw_request_admin->user_code = session()->get('user_code');

            $admin->balance = intval($admin->balance);

            $withdraw_request_admin->amount = intval($request->amount);
            
            $admin->withdraws = intval($admin->withdraws);

            $new_balance = $admin->balance - $request->amount;

            $new_withdraws = $admin->withdraws + $request->amount;


            $admin->balance = $new_balance;

            $admin->withdraws = $new_withdraws;

            $withdraw_request_admin->save();

            $admin->update();
            
            $subject_admin_user = 'Withdraw request.';

            $body_admin_user = '
            Hello, <br><br>
            Your withdraw request has been sent. It may take some time for payment. <br> <br>
            Thank you, <br>
            Effort E-learning MP.
            ';

            Mail::to($admin->email)->send(new SendMail($subject_admin_user, $body_admin_user));
            
            $subject_admin = 'Withdraw request.';

            $body_admin = '
            Hello, <br><br>
            A new withdraw request was created. Please check withdraw information for approval. <br> <br>
            Thank you, <br>
            Effort E-learning MP.
            ';

            Mail::to('mpeffortelearning@gmail.com')->send(new SendMail($subject_admin, $body_admin));

            return redirect()->back()->with('success', 'Withdraw Request Submited..!');

        }else{
            
            return redirect()->back()->with('error', 'Insufficient Balance..!');
        }


    }













    
}


