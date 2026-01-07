<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'receiver_role',
        'type',
        'title',
        'message',
        'reference_id',
        'reference_type',
        'is_read',
    ];
}
