<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CommentController extends Controller
{
    // handling comment section
            public function storeComment(Request $request)
            {
                $request->validate([
                    'course_id' => 'required',
                    'comment' => 'required|string'
                ]);

                // Check enrollment + approved payment
                $enrollment = Enrollment::where('student_id', Auth::user()->id)
                    ->where('course_id', $request->course_id)
                    ->where('payment_status', 'approved')
                    ->first();

                if (!$enrollment) {
                    Alert::error('Access Denied', 'Only approved enrolled students can comment.');
                    return back();
                }

                Comment::create([
                    'course_id'  => $request->course_id,
                    'student_id' => Auth::user()->id,
                    'comment'    => $request->comment,
                ]);

                Alert::success('Success', 'You have successfully commented');
                return back();
            }

        // delete comment
        public function deleteComment($id)
        {
            Comment::where('id', $id)
                ->where('student_id', Auth::user()->id)
                ->delete();

            Alert::success('Success', 'You have successfully deleted your comment');
            return back();
        }

        }
