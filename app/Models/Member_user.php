<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member_user extends Model
{
    use HasFactory;

    protected $table = "member_users";

    protected $primaryKey = "member_id";

    protected $fillable = [
        'name',
        'phone',
        'email',
        'email_verified',
        'verify_token',
        'whatsapp',
        'gender',
        'home_town',
        'city',
        'country',
        'balance',
        'withdraws',
        'user_code',
        'parent_user_code',
        'group_leader_code',
        'group_leader_id',
        'teacher_id',
        'head_teacher_id',
        'presenter_id',
        'cp_id',
        'executive_id',
        'eo_id',
        'seo_id',
        'director_id',
        'dg_id',
        'presenter_approval',
        'cp_approval',
        'executive_approval',
        'eo_approval',
        'seo_approval',
        'director_approval',
        'dg_approval',
        'course_id',
        'role_id',
        'status',
        'pro_pic',
        'password',
    ];

    
    static public function member(){
        return self::find(session()->get('member_id'));
    }
    
    static public function refered_inactive_member(){
        return self::where('parent_user_code', session()->get('user_code'))->where('status', 0)->get();
    }
    
    static public function refered_active_member(){
        return self::where('parent_user_code', session()->get('user_code'))->where('status', 1)->get();
    }





}


