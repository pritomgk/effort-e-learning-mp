<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_user extends Model
{

    use HasFactory;

    protected $table = 'admin_users';

    protected $primaryKey = 'admin_id';

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
        'parent_id',
        'user_code',
        'parent_user_code',
        'pro_pic',
        'role_id',
        'status',
        'password',
    ];

    
    
    static public function admin(){
        return self::find(session()->get('admin_id'));
    }
    
    static public function refered_inactive_member(){
        return self::where('parent_user_code', session()->get('user_code'))->where('status', 0)->get();
    }
    
    static public function refered_active_member(){
        return self::where('parent_user_code', session()->get('user_code'))->where('status', 1)->get();
    }






}


