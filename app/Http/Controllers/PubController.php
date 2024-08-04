<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PubController extends Controller
{

    public function home(){

        $courses = Course::all();

        return view('pub_view.home', compact('courses'));
        
    }

    public function contact_us(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'subject'=>'required',
            'message'=>'required',
        ]);

        $subject = "A person want to contact with you.";
        $body = 
        '
        Name : '.$request->name.'<br>
        Email : '.$request->email.'<br>
        Subject : '.$request->subject.'<br>
        Message : '.$request->message;
        // Mail::to('mpeffortelearning@gmail.com')->send(new SendMail($subject, $body));

        return "OK";

    }

}


