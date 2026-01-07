<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Enrollment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    // to payment page
                    public function paymentPage()
        {
            $payments = Payment::leftJoin('courses', 'payments.course_id', '=', 'courses.id')
                ->leftJoin('users as instructors', 'courses.teacher_id', '=', 'instructors.id') // Alias for teacher
                ->leftJoin('users as students', 'payments.student_id', '=', 'students.id')     // New Join for Student
                ->select(
                    'payments.id as payment_id',
                    'payments.status',
                    'payments.amount',
                    'payments.payment_method',
                    'payments.payslip',
                    'payments.created_at',
                    'courses.title as course_title',
                    'instructors.name as instructor_name',
                    'students.name as student_name' // Add this to see who paid
                )
                ->when(request('searchKey'), function ($query) {
                    $query->where('courses.title', 'like', '%' . request('searchKey') . '%')
                        ->orWhere('instructors.name', 'like', '%' . request('searchKey') . '%')
                        ->orWhere('students.name', 'like', '%' . request('searchKey') . '%'); // Search by student too
                })
                ->orderBy('payments.created_at', 'desc')
                ->paginate(5);

            return view('Admin.Payment.paymentList', compact('payments'));
        }


            // admin update status
                public function updateStatus($id)
                {
                    $status = request('status');
                    $payment = Payment::findOrFail($id);

                    try {
                        if ($status === 'approved') {
                            // 1. Update payment status
                            $payment->update(['status' => 'approved']);

                            // 2. Create or update enrollment
                            Enrollment::updateOrCreate(
                                [
                                    'student_id' => $payment->student_id,
                                    'course_id' => $payment->course_id
                                ],
                                [
                                    'payment_status' => 'approved',
                                    'roll_call' => null
                                ]
                            );

                            // 3. SAVE NOTIFICATION
                            Notification::create([
                                'sender_id'      => Auth::user()->id,
                                'receiver_id'    => $payment->student_id,
                                'receiver_role'  => 'student',
                                'type'           => 'payment',
                                'title'          => 'Payment Approved',
                                'message'        => 'Your payment has been approved. You can now access the course.',
                                'reference_id'   => $payment->id,
                                'reference_type' => 'payment',
                                'is_read'        => 0,
                            ]);

                            Alert::success('Success', "Payment Approved & Student Enrolled.");
                            return back();

                        }
                        elseif ($status === 'rejected') {

                            // delete payslip
                            if ($payment->payslip) {
                                $filePath = public_path('/paySlip/' . $payment->payslip);
                                if (file_exists($filePath)) {
                                    unlink($filePath);
                                }
                            }

                            // update payment
                            $payment->update(['status' => 'rejected']);

                            //  UPDATE ENROLLMENT TOO
                            Enrollment::updateOrCreate(
                                [
                                    'student_id' => $payment->student_id,
                                    'course_id'  => $payment->course_id,
                                ],
                                [
                                    'payment_status' => 'rejected',
                                ]
                            );

                            // notification
                            Notification::create([
                                'sender_id'      => Auth::user()->id,
                                'receiver_id'    => $payment->student_id,
                                'receiver_role'  => 'student',
                                'type'           => 'payment',
                                'title'          => 'Payment Rejected',
                                'message'        => 'Your payment was rejected. Please re-upload your payment slip.',
                                'reference_id'   => $payment->id,
                                'reference_type' => 'payment',
                                'is_read'        => 0,
                            ]);

                            Alert::success('Success', "Payment Rejected.");
                            return back();
                        }

                    } catch (\Exception $e) {
                        // If the notification fails, this will tell you WHY
                        Alert::error('Error', 'Something went wrong: ' . $e->getMessage());
                        return back();
                    }
                }
}
