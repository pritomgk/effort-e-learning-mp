<?php

namespace App\Http\Controllers;

use App\Models\Member_user;
use App\Models\Payment_method;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    
    public function member_payment_methods(){
        $member_payment_methods = Payment_method::where('member_id', session()->get('member_id'))->get();

        $all_members = Member_user::all();

        return view('member_view.withdrawal', compact('member_payment_methods', 'all_members'));
    }
    
    
    public function add_member_payment_methods(Request $request){

        $request->validate([
            
        ]);

        $member_payment_methods = Payment_method::where('member_id', session()->get('member_id'))->get();

        $all_members = Member_user::all();

        return view('member_view.withdrawal', compact('member_payment_methods', 'all_members'));

    }
    
}


