<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    //
    protected $fillable = ['student_id','course_id','roll_call','payment_status'];
}
