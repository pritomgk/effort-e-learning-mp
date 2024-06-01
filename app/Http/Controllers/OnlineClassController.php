<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Course;
use App\Models\Member_user;
use App\Models\Online_class;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OnlineClassController extends Controller
{

    public function member_online_class($course_id){

        $course_classes = Online_class::where('course_id', $course_id)->get();

        return view('member_view.classes', compact('course_classes'));

    }
    

    public function create_class(){

        $courses = Course::all();

        return view('admin_view.common.create_class', compact('courses'));

    }

    public function add_class_info(Request $request){

        $request->validate(
            [
            "title" => "required",
            "class_date" => "required",
            "class_start_time" => "required",
            "class_end_time" => "required",
            "class_link" => "required",
        ]);

        $new_class = new Online_class();

        

        if (!empty($request->image)) {

            $new_class->course_id = $request->course_id;

        }else{
            
            $new_class->course_id = 0;
        }

        $new_class->title = $request->title;
        $new_class->class_date = $request->class_date;
        $new_class->class_start_time = $request->class_start_time;
        $new_class->class_end_time = $request->class_end_time;
        $new_class->class_link = $request->class_link;
        $new_class->save();

        $all_member = Member_user::all();

        foreach ($all_member as $member) {
            
            $subject_member = 'New class alert.';

                    
            $body_member = '
            Hello '.$member->name.', <br><br>
            A new class has been scheduled. <br> <br>
            Check your dashboard. <br>
            Thank you, <br>
            Effort E-learning MP.
            ';

            Mail::to($member->email)->send(new SendMail($subject_member, $body_member));
        }
        

        return redirect()->back()->with('success', 'Class successfully created..!');

    }

    public function view_classes(){

        $online_classes = Online_class::all();
        $courses = Course::all();

        return view('admin_view.common.view_classes', compact('online_classes', 'courses'));

    }

    public function delete_class($class_id){

        $delete_class = Online_class::find($class_id)->delete();

        return redirect()->back()->with('error', 'Class Deleted..!');

    }


}


