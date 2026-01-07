<?php

namespace App\Http\Controllers\Student;

use App\Models\Course;
use App\Models\Rating;
use App\Models\Report;
use App\Models\Comment;
use App\Models\Payment;
use App\Models\Assignment;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Submission;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class StudentController extends Controller
{
    // direct to student dashboard
    public function dashboard(){
        // return view('Student.dashboard');
        $userId = Auth::user()->id;

        // 1. Get real count of courses student has paid for
        $enrolledCount = Payment::where('student_id', $userId)
                                ->where('status', 'approved')
                                ->count();

        // 2. Calculate Total Spent (using 'amount' column)
        $totalSpent = Payment::where('student_id', $userId)
                             ->where('status', 'approved')
                             ->sum('amount');

        // 3. Fetch the 2 most recent courses student enrolled in
        $recentCourses = Payment::join('courses', 'payments.course_id', '=', 'courses.id')
                                ->join('users', 'courses.teacher_id', '=', 'users.id')
                                ->where('payments.student_id', $userId)
                                ->where('payments.status', 'approved')
                                ->select('courses.*', 'users.name as teacher_name')
                                ->latest('payments.created_at')
                                ->take(2)
                                ->get();


        $myCourseIds = Payment::where('student_id', $userId)
                          ->where('status', 'approved')
                          ->pluck('course_id');

        $upcomingAssignments = Assignment::whereIn('course_id', $myCourseIds)->latest()->get();

        // 2. Get assignments that belong to those courses
        foreach ($upcomingAssignments as $task) {
        $task->is_submitted = Submission::where('assignment_id', $task->id)
                                                    ->where('student_id', $userId)
                                                    ->exists();
         }

        return view('Student.dashboard', compact('enrolledCount', 'totalSpent', 'recentCourses','upcomingAssignments'));
    }

     // to the browse course list page
     public function browselist(){
         $departments = Department::select('id','name')->get();
         $courses = Course::leftJoin('departments', 'courses.department_id', '=', 'departments.id')
                            ->select(
                                'courses.id',
                                'courses.title',
                                'courses.description',
                                'courses.price',
                                'courses.image',
                                'courses.department_id',
                                'departments.name as department_name'
                            )
                            ->when( request('searchKey') ,function($query){ $query->whereAny( ['courses.title','courses.description','courses.price'], 'like' , '%'.request('searchKey').'%' ); })
                            ->when(request('department'), function ($query) {
                                    $query->where('courses.department_id', request('department'));
                                })
                            ->get();
        return view('Student.Course.browseCourse',compact('departments','courses'));
     }

            // course detail
        public function detail($id)
    {
         $course = Course::leftJoin('departments', 'courses.department_id', '=', 'departments.id')
                            ->leftJoin('users', 'courses.teacher_id', '=', 'users.id')
                            ->select(
                                'courses.id',
                                'courses.title',
                                'courses.description',
                                'courses.price',
                                'courses.image',
                                'departments.name as department_name',
                                'users.name as instructor_name',
                                'users.profile as instructor_image'
                            )
                            ->where('courses.id', $id)
                            ->first();

                        // default states
                            $isEnrolled = false;
                            $isPending = false;

                            // check enrollment (approved only)
                            $enrollment = Enrollment::where('student_id', Auth::id())
                                ->where('course_id', $id)
                                ->where('payment_status', 'approved')
                                ->first();

                            if ($enrollment) {
                                $isEnrolled = true;
                            }
                            // check reject payment
                            $isRejected = false;

                            $rejectedPayment = Payment::where('student_id', Auth::id())
                                ->where('course_id', $id)
                                ->where('status', 'rejected')
                                ->first();

                            if ($rejectedPayment) {
                                $isRejected = true;
                            }

                            // check pending payment
                            $pendingPayment = Payment::where('student_id', Auth::id())
                                ->where('course_id', $id)
                                ->where('status', 'pending')
                                ->first();

                            if ($pendingPayment) {
                                $isPending = true;
                            }

                        // rating info
                        $avgRating = Rating::where('course_id', $id)->avg('rating');
                        $totalRating = Rating::where('course_id', $id)->count();

                        // my rating (if exists)
                        $myRating = Rating::where('course_id', $id)
                            ->where('student_id', Auth::user()->id)
                            ->first();

                        // for comment

                        $comments = Comment::leftJoin('users', 'comments.student_id', '=', 'users.id')
                                                ->where('comments.course_id', $id)
                                                ->select(
                                                    'comments.id',
                                                    'comments.comment',
                                                    'comments.created_at',
                                                    'comments.student_id',
                                                    'users.name',
                                                    'users.profile'
                                                )
                                                ->orderBy('comments.created_at', 'desc')
                                                ->get();

                        return view('Student.Course.detail', compact(
                            'course',
                            'isEnrolled',
                            'enrollment',
                            'isPending',
                            'isRejected',
                            'avgRating',
                            'totalRating',
                            'myRating',
                            'comments'
                        ));
    }

        // rating section
        public function saveRating(Request $request){
            // check enrolled
    $enrolled = Enrollment::where('student_id', Auth::id())
                            ->where('course_id', $request->course_id)
                            ->where('payment_status', 'approved')
                            ->exists();

                        if (!$enrolled) {
                            return back();
                        }

                        // save or update rating
                        Rating::updateOrCreate(
                            [
                                'course_id' => $request->course_id,
                                'student_id' => Auth::id(),
                            ],
                            [
                                'rating' => $request->rating,
                                'review' => $request->review,
                            ]
                        );
                        Alert::success('Success', 'You have successfully rating this course');

                        Return back();
        }


        // to payment page
        public function paymentPage($id){
            $course = Course::leftJoin('departments', 'courses.department_id', '=', 'departments.id')
                ->leftJoin('users', 'courses.teacher_id', '=', 'users.id')
                ->select(
                    'courses.id',
                    'courses.title',
                    'courses.description',
                    'courses.price',
                    'courses.image',
                    'departments.name as department_name',
                    'users.name as instructor_name',
                    'users.profile as instructor_image'
                )
                ->where('courses.id', $id)
                ->first();
            return view('Student.Payment.paymentPage',compact('course'));
        }

        // creating payment page
        public function createPayment(Request $request){

            $this->checkPaymentValidation($request);

        $data = $this->getPaymentData($request);

        // Handle payslip upload
        if ($request->hasFile('paySlip')) {
            $fileName = uniqid() . '_' . $request->file('paySlip')->getClientOriginalName();
            $request->file('paySlip')->move(public_path('/paySlip/'), $fileName);
            $data['payslip'] = $fileName;
        }

        Payment::create($data);

        Alert::success('Success', 'Payment submitted successfully. Please wait for approval.');

        return to_route('student#dashboard');
        }

        // to my course
        public function mycourse(){

             $courses = Payment::leftJoin('courses', 'payments.course_id', '=', 'courses.id')
                                    ->leftJoin('users', 'courses.teacher_id', '=', 'users.id')
                                    ->select(
                                        'payments.id as payment_id',
                                        'payments.status',
                                        'payments.amount',
                                        'courses.id as course_id',
                                        'courses.title',
                                        'courses.image',
                                        'users.name as instructor_name'
                                    )
                                    ->where('payments.student_id', Auth::user()->id)
                                    ->when(request('searchKey'), function ($query) {
                                        $query->whereAny(
                                            ['courses.title', 'users.name'],
                                            'like',
                                            '%' . request('searchKey') . '%'
                                        );
                                    })
                                    ->orderBy('payments.created_at', 'desc')
                                    ->paginate(2); // ← number of items per page

                            return view('Student.Course.myCourse', compact('courses'));
        }

        // to payment history
        public function paymentHistory(){
           $payments = Payment::leftJoin('courses', 'payments.course_id', '=', 'courses.id')
                                ->leftJoin('users', 'courses.teacher_id', '=', 'users.id')
                                ->select(
                                    'payments.id as payment_id',
                                    'payments.status',
                                    'payments.amount',
                                    'payments.payment_method',
                                    'payments.payslip',
                                    'payments.created_at',
                                    'courses.title as course_title',
                                    'users.name as instructor_name'
                                )
                                ->where('payments.student_id', Auth::user()->id)
                                ->when(request('status'), function ($query) {
                                    $query->where('payments.status', request('status'));
                                })
                                ->latest('payments.created_at')
                                ->get();

                            $totalSpent = $payments
                                ->where('status', 'approved')
                                ->sum('amount');

                            return view('Student.Payment.paymentHistory', compact('payments', 'totalSpent'));
        }

        // delete history
        public function deleteHistory($id){
              Payment::where('id', $id)
                        ->where('student_id', Auth::user()->id)
                        ->delete();


            Alert::success('Success', 'Payment history deleted successfully');

         return to_route('student#browselist');
        }

        // payment validate
        private function checkPaymentValidation(Request $request)
            {
                $request->validate([
                    'course_id' => 'required',
                    'payment_method' => 'required',
                    'amount' => 'required',
                    'paySlip' => 'required|image|mimes:jpg,jpeg,png|max:5120',
                ]);
            }

            // student noti page
           public function noti() {
            $studentId = Auth::user()->id;
            Notification::where('receiver_id', $studentId)
                        ->where('is_read', 0)
                        ->update(['is_read' => 1]);

            $notifications = Notification::where('receiver_id', $studentId)
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(10);

            return view('Student.Notification.studentNoti', compact('notifications'));
        }
        // to student , my grade collection page
        public function myGrade()
            {
                $studentId = Auth::user()->id;

                $grades = Submission::where('student_id', $studentId)
                                        ->whereNotNull('grade') // Only show graded items
                                        ->join('assignments', 'submissions.assignment_id', 'assignments.id')
                                        ->join('courses', 'assignments.course_id', 'courses.id')
                                        ->when(request('searchKey'), function($query) {
                                            $query->whereAny(['assignments.task', 'courses.title'], 'like', '%' . request('searchKey') . '%');
                                        })
                                        ->select(
                                            'submissions.*',
                                            'assignments.task as assignment_task',
                                            'courses.title as course_title'
                                        )
                                        ->orderBy('submissions.updated_at', 'desc')
                                        ->paginate(10);

                return view('Student.Grade.myGrade', compact('grades'));
            }

        // to student grade page from noti
        public function gradePage()
        {
            $studentId = Auth::user()->id;

            $grades =Submission::where('student_id', $studentId)
                                ->whereNotNull('grade') // Only show things already graded
                                ->leftJoin('assignments', 'submissions.assignment_id', 'assignments.id')
                                ->leftJoin('courses', 'assignments.course_id', 'courses.id')
                                ->select(
                                    'submissions.*',
                                    'assignments.task as assignment_title',
                                    'courses.title as course_title'
                                )
                                ->orderBy('submissions.updated_at', 'desc')
                                ->paginate(10);

            return view('Student.Grade.gradeHistory', compact('grades'));
        }

        public function gradeDetail($id)
        {
            // Ensure the student can only see THEIR OWN grade
            $grade = Submission::where('submissions.id', $id)
                ->where('student_id', Auth::user()->id)
                ->leftJoin('assignments', 'submissions.assignment_id', 'assignments.id')
                ->leftJoin('courses', 'assignments.course_id', 'courses.id')
                ->select('submissions.*', 'assignments.task', 'courses.title as course_name')
                ->firstOrFail();

            return view('Student.Grade.viewGrade', compact('grade'));
        }

        // to student report history
        // Show the history
public function viewReport(){
    $reports = Report::where('user_id', Auth::user()->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
    return view('Student.Report.viewReport', compact('reports'));
}

// Show the create page with Department options
        public function createReportPage()
        {
            $departments = Department::orderBy('name', 'asc')->get();
            return view('Student.Report.createReport', compact('departments'));
        }

        // Save the report
        public function sendReport(Request $request) {
            $request->validate([
                'department_id' => 'required', // Student picks the target dep
                'title' => 'required|min:5',
                'message' => 'required|min:10',
            ]);

            Report::create([
                'user_id' => Auth::user()->id,
                'department_id' => $request->department_id,
                'title' => $request->title,
                'message' => $request->message
            ]);

            Alert::success('Success', 'Report submitted to the department.');
            return to_route('student#viewReport');
        }

        // payment data info
        private function getPaymentData(Request $request)
            {
                return [
                    'student_id' => Auth::user()->id,
                    'course_id' => $request->course_id,
                    'payment_method' => $request->payment_method,
                    'amount' => $request->amount,
                    'status' => 'pending',
                ];
            }



}
