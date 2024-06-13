<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passbook extends Model
{
    use HasFactory;

    protected $table = 'passbooks';

    protected $primaryKey = 'record_id';

    protected $fillable = [
        'sender_name',
        'receiver_name',
        'sender_member_id',
        'sender_admin_id',
        'receiver_member_id',
        'receiver_admin_id',
        'amount',
        'sender_user_code',
        'receiver_user_code',
    ];

}


