<?php

namespace App\Http\Controllers\Teacher;

use App\Models\User;
use App\Models\Course;
use App\Models\Report;
use App\Models\Payment;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class TeacherController extends Controller
{
    // to teacher dashboard
    public function dashboard() {
            $teacherId = Auth::user()->id;

            // 1. Get Teacher's Courses
            $myCourses = Course::where('teacher_id', $teacherId)->get();
            $courseCount = $myCourses->count();

            // 2. Total Students (Sum of all approved payments for this teacher's courses)
            $totalStudents = Payment::whereIn('course_id', $myCourses->pluck('id'))
                                    ->where('status', 'approved')
                                    ->count();

            // 3. Pending Reviews (Submissions that have NO grade yet)
            $pendingReviewsCount = Submission::whereIn('assignment_id', function($query) use ($teacherId) {
                                        $query->select('id')->from('assignments')->where('teacher_id', $teacherId);
                                    })
                                    ->whereNull('grade')
                                    ->count();

            // 4. Pending Submissions List (to show in the "Pending Reviews" section)
            $pendingSubmissions = Submission::join('assignments', 'submissions.assignment_id', 'assignments.id')
                                                ->join('courses', 'assignments.course_id', 'courses.id') // Join with courses
                                                ->join('users', 'submissions.student_id', 'users.id')
                                                ->where('assignments.teacher_id', $teacherId)
                                                ->whereNull('submissions.grade')
                                                // Use courses.title instead of assignments.title
                                                ->select('submissions.*', 'courses.title as course_name', 'users.name as student_name')
                                                ->latest()
                                                ->take(5)
                                                ->get();

            return view('Teacher.dashboard', compact(
                'courseCount',
                'totalStudents',
                'pendingReviewsCount',
                'myCourses',
                'pendingSubmissions'
            ));
        }

    // to teacher noti page
    public function noti() {
    $teacherId = Auth::user()->id;

    // 1. Mark as read
    Notification::where('receiver_id', $teacherId)
                ->where('is_read', 0)
                ->update(['is_read' => 1]);

    // 2. Get Notifications with Assignment Task name
    $notifications = Notification::where('receiver_id', $teacherId)
                                    ->leftJoin('submissions', 'notifications.reference_id', 'submissions.id')
                                    ->leftJoin('assignments', 'submissions.assignment_id', 'assignments.id')
                                    ->select(
                                        'notifications.*',
                                        'assignments.id',
                                        'submissions.grade as student_grade'
                                    )
                                    ->orderBy('notifications.created_at', 'desc')
                                    ->paginate(10);

    return view('Teacher.Notification.teacherNoti', compact('notifications'));
}

    // to teacher grade page after click noti
           public function teacherGrade($id)
            {
                $submission = Submission::where('submissions.id', $id)
                                        ->leftJoin('users', 'submissions.student_id', 'users.id')
                                        ->leftJoin('assignments', 'submissions.assignment_id', 'assignments.id')
                                        ->select(
                                            'submissions.*',
                                            'users.name as student_name',
                                            'assignments.task as assignment_title'
                                        )
                                        ->first();

                if (!$submission) {
                    return back()->with('error', 'Submission not found');
                }

                return view('Teacher.Grade.teacherGrade', compact('submission'));
            }

        // teacher submit grade
        public function submitGrade(Request $request, $id) {
            // 1. Validation
                $request->validate([
                    'grade' => 'required|numeric|min:0|max:10',
                    'feedback' => 'required'
                ]);

                // 2. Find the submission and update it
                $submission = Submission::findOrFail($id);
                $submission->update([
                    'grade' => $request->grade,
                    'feedback' => $request->feedback
                ]);

                // 3. Get extra info for the notification message
                $assignment = Assignment::find($submission->assignment_id);

                // 4. Send Notification to Student
                Notification::create([
                    'sender_id'      => Auth::user()->id,         // Teacher
                    'receiver_id'    => $submission->student_id,  // Student
                    'receiver_role'  => 'student',
                    'type'           => 'grade',
                    'title'          => 'Assignment Graded',
                    'message'        => 'Your work for "' . $assignment->task . '" has been graded. Score: ' . $request->grade . '/10',
                    'reference_id'   => $submission->id,
                    'reference_type' => 'submission',
                    'is_read'        => 0
                ]);

                Alert::success('Success', 'Grade submitted successfully');
                return to_route('teacher#Noti');
            }

            // teacher gade and analytic page
            public function myGrade() {
            $teacherId = Auth::user()->id;

            $grades = Submission::whereNotNull('submissions.grade')
                                ->leftJoin('users', 'submissions.student_id', 'users.id')
                                ->leftJoin('assignments', 'submissions.assignment_id', 'assignments.id')
                                ->where('assignments.teacher_id', $teacherId)
                                ->when(request('searchKey'), function($query) {
                                    $query->whereAny(
                                        ['users.name', 'users.email', 'assignments.task'],
                                        'like',
                                        '%'.request('searchKey').'%'
                                    );
                                })
                                ->select(
                                    'submissions.*',
                                    'users.name as student_name',
                                    'users.email as student_email',
                                    'assignments.task as assignment_task'
                                )
                                ->orderBy('submissions.updated_at', 'desc')
                                ->paginate(10);

            return view('Teacher.Grade.gradePage', compact('grades'));
        }

        // to my student page
        public function myStudents()
            {
                $teacherId = Auth::user()->id;

                $students = User::where('role', 'student')
                    ->join('enrollments', 'users.id', 'enrollments.student_id')
                    ->join('courses', 'enrollments.course_id', 'courses.id')
                    ->where('courses.teacher_id', $teacherId)
                    ->where('enrollments.payment_status', 'approved')
                    ->when(request('searchKey'), function ($query) {
                        $query->where(function ($q) {
                            $q->where('users.name', 'like', '%' . request('searchKey') . '%')
                            ->orWhere('users.email', 'like', '%' . request('searchKey') . '%')
                            ->orWhere('courses.title', 'like', '%' . request('searchKey') . '%');
                        });
                    })
                    ->select(
                        'users.*',
                        'courses.title as course_title',
                        'enrollments.roll_call',
                        'enrollments.payment_status'
                    )
                    ->orderBy('enrollments.created_at', 'desc')
                    ->paginate(10);

                return view('Teacher.Profile.myStudents', compact('students'));
            }

        // to teacher review history page
        public function viewReport(){
            $reports = Report::where('user_id', Auth::user()->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

            return view('Teacher.Report.viewReport', compact('reports'));
        }

       // Show the form page
           public function createReportPage() {
    // Logic: Find the department through the teacher's course
                $teacherData = User::select('departments.name as department_name')
                    ->leftJoin('courses', 'courses.teacher_id', 'users.id')
                    ->leftJoin('departments', 'departments.id', 'courses.department_id')
                    ->where('users.id', Auth::user()->id)
                    ->first();

                return view('Teacher.Report.createReport', compact('teacherData'));
            }

            public function sendReport(Request $request) {
                $request->validate([
                    'title' => 'required|min:5|max:100',
                    'message' => 'required|min:10',
                ]);

                Report::create([
                    'user_id' => Auth::user()->id,
                    'title' => $request->title,
                    'message' => $request->message
                ]);

                Alert::success('Report Sent', 'Your issue has been submitted to the Admin successfully!');
                return to_route('teacher#viewReport');
            }
}
