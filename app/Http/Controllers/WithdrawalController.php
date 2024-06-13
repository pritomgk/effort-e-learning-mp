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
        
        $dg = Admin_user::where('user_code', '240003')->first();
        
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

            // Mail::to('mpeffortelearning@gmail.com')->send(new SendMail($subject_admin, $body_admin));

            return redirect()->back()->with('success', 'Withdraw Request Submited..!');

        }else{
            
            return redirect()->back()->with('error', 'Insufficient Balance..!');
        }


    }

    public function member_debit_passbook(Request $request){

        $member_debit_passbooks = Withdrawal::where('member_id', session()->get('member_id'))->get();

        return view('member_view.member_debit_passbook', compact('member_debit_passbooks'));

    }















    
}


