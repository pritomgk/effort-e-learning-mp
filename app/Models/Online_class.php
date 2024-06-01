<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Online_class extends Model
{
    use HasFactory;

    protected $table = 'online_classes';

    protected $primaryKey = 'class_id';

    protected $fillable = [
        'title',
        'class_date',
        'class_start_time',
        'class_end_time',
        'class_link',
        'course_id',
    ];

}


