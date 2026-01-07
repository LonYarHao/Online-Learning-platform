<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Course;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    //direct to admin page
    public function dashboard() {
    // 1. Count Users by Role (assuming role 0=student, 1=teacher, 2=admin)
            $studentCount = User::where('role', 'student')->count();
            $teacherCount = User::where('role', 'teacher')->count();

            // 2. Count Active Courses
            $courseCount = Course::count();

            // 3. Calculate Total Revenue (Sum of all approved payments)
            $totalRevenue = Payment::where('status', 'approved')->sum('amount');

            // 4. Fetch Recent Enrollments (Joins users and courses)
            $recentEnrollments = Payment::join('users', 'payments.student_id', '=', 'users.id')
                                    ->join('courses', 'payments.course_id', '=', 'courses.id')
                                    ->select('payments.*', 'users.name as student_name', 'courses.title as course_title')
                                    ->latest('payments.created_at')
                                    ->take(5)
                                    ->get();

            return view('Admin.dashboard', compact(
                'studentCount',
                'teacherCount',
                'courseCount',
                'totalRevenue',
                'recentEnrollments'
            ));
        }

    // admin list page
    public function adminlist(){
       $adminList = User::select('id','profile','name','user_name','email','phone','address','role','provider')
              ->whereIn('role',['admin','superadmin'])
               ->when( request('searchKey') ,function($query){
                        $query->whereAny( ['name','email','address','phone','provider','role'], 'like' , '%'.request('searchKey').'%' );
                    })
              ->paginate(2);
        return view('Admin.Account.adminlist',compact('adminList'));
    }

    // create new admin page
    public function createAdminPage(){
        return view('Admin.Account.newAdmin');
    }

    // delete admin
    public function adminDelete($id){
        User::where('id',$id)->delete();

         Alert::success('Success Title', 'delete Admin successully');

         return to_route('account#adminList');
    }
    // create Admin
    public function createAdmin(Request $request){
        $this->checkValidation($request);

        User::create([
          'name'=> $request->name,
          'email'=> $request->email,
          'password'=> Hash::make($request->password),
          'role'=> 'admin'
        ]);
         Alert::success('Success Title', 'create Admin successully');

         return to_route('account#adminList');
    }


    // To techer list page
    public function teacherlist(){
         $teacherList = User::select('id','profile','name','user_name','email','phone','address','role','provider')
              ->where('role','teacher')
               ->when( request('searchKey') ,function($query){
                        $query->whereAny( ['name','email','address','phone','provider','role'], 'like' , '%'.request('searchKey').'%' );
                    })
              ->paginate(2);
        return view('Admin.Account.teacherList',compact('teacherList'));
    }

    // create teacher page
    public function createTeacherPage(){
        return view('Admin.Account.newTeacher');
    }

    public function createTeacher(Request $request){
        $this->checkValidation($request);

        User::create([
          'name'=> $request->name,
          'email'=> $request->email,
          'password'=> Hash::make($request->password),
          'role'=> 'teacher'
        ]);
         Alert::success('Success Title', 'create teacher successully');

         return to_route('account#teacherList');
    }

    // delete teacher account

    public function teacherDelete($id){
        User::where('id',$id)->delete();

         Alert::success('Success Title', 'delete teacher successully');

         return to_route('account#teacherList');
    }

   // to student list page
   public function studentlist(){
    $studentList = User::select('id','profile','name','user_name','email','phone','address','role','provider')
              ->where('role','student')
               ->when( request('searchKey') ,function($query){
                        $query->whereAny( ['name','email','address','phone','provider','role'], 'like' , '%'.request('searchKey').'%' );
                    })
              ->paginate(2);
    return view('Admin.Account.studentlist',compact('studentList'));
   }

   // to student create page
   public function createStudentPage(){
     return view('Admin.Account.newStudent');
   }

    public function createStudent(Request $request){
      $this->checkValidation($request);

        User::create([
          'name'=> $request->name,
          'email'=> $request->email,
          'password'=> Hash::make($request->password),
          'role'=> 'student'
        ]);
         Alert::success('Success Title', 'create student successully');

         return to_route('account#studentList');
    }

    // delete stuednt
    public function studentDelete($id){
         User::where('id',$id)->delete();

         Alert::success('Success Title', 'delete student successully');

         return to_route('account#studentList');
    }


    private function checkValidation($request){
        $request->validate([
          'name'=>'required',
          'email'=>'required|unique:users,email',
          'password'=>'required|min:6|max:12',
          'confirmPassword'=>'required|min:6|max:12|same:password',
        ]);
    }
}
