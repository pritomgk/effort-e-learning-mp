<?php

namespace App\Http\Controllers;

use App\Models\Admin_user;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function add_course(){
        return view('admin_view.common.add_course');
    }

    public function add_course_info(Request $request){
        
        $request->validate(
            [
            "title" => "required",
            "description" => "required",
        ]);

        $course = new Course();

        $image_name = null;

        if (!empty($request->image)) {

            $request->validate([
                "image"=> "required|max:7240",
            ]);

            $name = $request->title;
            $image_name = $name.'_image_'.date("Y_m_d_h_i_sa").'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('storage/uploads/image/'), $image_name);


        }

        $course->title = $request->title;
        $course->description = $request->description;
        $course->image = $image_name;
        $course->admin_id = session()->get('admin_id');
        $course->save();

        return redirect()->back()->with('success', 'Course successfully saved..!');
        
    }

    public function view_courses(){

        $courses = Course::all();

        $admin_users = Admin_user::all();

        return view('admin_view.common.view_course', compact('courses', 'admin_users'));

    }

    public function update_course_info(Request $request){
        
        $request->validate(
            [
            "title" => "required",
            "description" => "required",
        ]);

        $course = Course::find($request->course_id);

        $image_name = null;

        if (!empty($request->image)) {

            $request->validate([
                "image"=> "required|max:7240",
            ]);

            $name = $request->title;
            $image_name = $name.'_image_'.date("Y_m_d_h_i_sa").'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('storage/uploads/image/'), $image_name);


        }

        $course->title = $request->title;
        $course->description = $request->description;
        $course->image = $image_name;
        $course->admin_id = session()->get('admin_id');
        $course->save();

        return redirect()->back()->with('success', 'Course successfully saved..!');
        
    }

    public function view_member_courses(){

        $courses = Course::all();


        return view('member_view.courses', compact('courses'));

    }


}



