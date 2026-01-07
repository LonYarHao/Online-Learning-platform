<?php

namespace App\Http\Controllers\Student;

use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class StudentAssignmentController extends Controller
{
    // to student assignment page
                        public function myAssignment()
        {
            $assignments = Assignment::join('courses', 'assignments.course_id', '=', 'courses.id')
                // 1. Join Enrollments to filter only courses the student belongs to
                ->join('enrollments', 'courses.id', '=', 'enrollments.course_id')
                ->leftJoin('users', 'assignments.teacher_id', '=', 'users.id')
                // 2. Join Submissions to check status
                ->leftJoin('submissions', function($join) {
                    $join->on('assignments.id', '=', 'submissions.assignment_id')
                        ->where('submissions.student_id', '=', Auth::user()->id);
                })
                // 3. Ensure we only see assignments for the LOGGED IN student's enrolled courses
                ->where('enrollments.student_id', Auth::user()->id)
                ->select(
                    'assignments.id as assignment_id',
                    'assignments.task',
                    'assignments.created_at',
                    'courses.title as course_title',
                    'users.name as teacher_name',
                    'submissions.file_path'
                )
                ->when(request('searchKey'), function ($query) {
                    $query->whereAny(
                        ['courses.title', 'users.name', 'assignments.task'],
                        'like',
                        '%' . request('searchKey') . '%'
                    );
                })
                ->latest('assignments.created_at')
                ->paginate(5);

            return view('Student.Assignment.myAssignment', compact('assignments'));
        }

    // student view assignment
    public function viewAssignment($id){
        $assignment = Assignment::leftJoin('courses', 'assignments.course_id', '=', 'courses.id')
                                    ->leftJoin('users', 'assignments.teacher_id', '=', 'users.id')
                                    ->select(
                                        'assignments.id',
                                        'assignments.task',
                                        'assignments.created_at',
                                        'courses.title as course_title',
                                        'users.name as teacher_name'
                                    )
                                    ->where('assignments.id', $id)
                                    ->firstOrFail();

    return view('Student.Assignment.viewAssignment', compact('assignment'));
    }


        // student submit assignment
            public function submitAssignment(Request $request)
        {
            // 1. Validation
            $request->validate([
                'assignment_id' => 'required|exists:assignments,id',
                'file' => 'required|mimes:pdf,doc,docx,zip|max:5120',
            ]);

            $data = [
                'assignment_id' => $request->assignment_id,
                'student_id' => Auth::user()->id,
            ];

            // 2. Handle File Upload
            if ($request->hasFile('file')) {
                $fileName = uniqid() . '_' . $request->file('file')->getClientOriginalName();
                $request->file('file')->move(public_path('/assignmentFile/'), $fileName);
                $data['file_path'] = $fileName;
            }

            // 3. Save the submission and keep it in a variable ($newSubmission)
            $newSubmission = Submission::create($data);

            // 4. FIND THE TEACHER (We need to know who created this assignment)
            $assignment = Assignment::find($request->assignment_id);
            $teacherId = $assignment->teacher_id; // Get the teacher's ID from the assignment

            // 5. CREATE THE NOTIFICATION for the teacher
            Notification::create([
                'sender_id'      => Auth::user()->id,           // The student
                'receiver_id'    => $teacherId,                // The teacher
                'receiver_role'  => 'teacher',                 // Role of the person getting noti
                'type'           => 'assignment',              // Category
                'title'          => 'New Assignment Submission',
                'message'        => Auth::user()->name . ' has uploaded a file for ' . $assignment->title,
                'reference_id'   => $newSubmission->id,        // ID from the submissions table
                'reference_type' => 'submission',              // Tells the system what the ID refers to
                'is_read'        => 0                          // 0 = New/Unread
            ]);

            Alert::success('Success', 'Assignment submitted successfully');
            return to_route('student#myAssignment');
        }
}
