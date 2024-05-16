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
        'parent_id',
        'refer_code',
        'parent_refer_code',
        'role_id',
        'status',
        'password',
    ];

}


