<?php

namespace App\Http\Controllers;

use App\Models\Member_user;
use App\Models\Payment_method;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    
    
    public function add_member_payment_methods(Request $request){

        $request->validate([
            'name'=>'required',
            'account_num'=>'required|min:8|max:16',
        ]);

        $add_member_payment_methods = new Payment_method();

        $add_member_payment_methods->name = $request->name;
        $add_member_payment_methods->account_num = $request->account_num;
        if ($request->name == 'Bkash') {
            $add_member_payment_methods->icon = 'bkash.png';
        }elseif ($request->name == 'Nagad') {
            $add_member_payment_methods->icon = 'nagad.png';
        }elseif ($request->name == 'Rocket') {
            $add_member_payment_methods->icon = 'rocket.png';
        }
                    
        $add_member_payment_methods->member_id = session()->get('member_id');
        $add_member_payment_methods->save();

        return redirect()->back()->with('success', 'Payment Method Added..!');

    }
    
    
    
    public function add_admin_payment_methods(Request $request){

        $request->validate([
            'name'=>'required',
            'account_num'=>'required|min:8|max:16',
        ]);

        $add_admin_payment_methods = new Payment_method();

        $add_admin_payment_methods->name = $request->name;
        $add_admin_payment_methods->account_num = $request->account_num;
        if ($request->name == 'Bkash') {
            $add_admin_payment_methods->icon = 'bkash.png';
        }elseif ($request->name == 'Nagad') {
            $add_admin_payment_methods->icon = 'nagad.png';
        }elseif ($request->name == 'Rocket') {
            $add_admin_payment_methods->icon = 'rocket.png';
        }
                    
        $add_admin_payment_methods->admin_id = session()->get('admin_id');
        $add_admin_payment_methods->save();

        return redirect()->back()->with('success', 'Payment Method Added..!');

    }
    





}


