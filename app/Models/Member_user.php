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
        'user_code',
        'parent_user_code',
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
        'role_id',
        'status',
        'password',
    ];

}


