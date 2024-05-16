<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_role extends Model
{
    use HasFactory;
    
    protected $table = 'user_roles';

    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'role_title',
    ];

}


