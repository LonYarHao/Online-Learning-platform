<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    //
      protected $fillable = [
        'course_id',
        'student_id',
        'rating',
        'review'
    ];
}
