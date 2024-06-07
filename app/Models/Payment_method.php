<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_method extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

    protected $primaryKey = 'method_id ';

    protected $fillable =[
        'name',
        'icon',
        'account_num',
        'admin_id',
        'member_id',
    ];



}


