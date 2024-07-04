<?php

namespace App\Http\Controllers;

use App\Models\Passbook;
use Illuminate\Http\Request;

class PassbookController extends Controller
{
    
    public function member_passbook(Request $request){

        $member_passbooks = Passbook::where('receiver_member_id', session()->get('member_id'))->get();

        return view('member_view.member_passbook', compact('member_passbooks'));

    }
    










}


