<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // to notificatin page
    public function noti(){
       $pendingPayments = Payment::where('payments.status', 'pending')
                                    ->leftJoin('users', 'payments.student_id', '=', 'users.id')
                                    ->select(
                                        'payments.*',
                                        'users.name as student_name'
                                    )
                                    ->latest('payments.created_at')
                                    ->get();


    return view('Admin.Notification.adminNoti', compact('pendingPayments'));
    }
}
