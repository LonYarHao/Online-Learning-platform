<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CourseController extends Controller
{
    // to course list
    public function courseList(){
         $courses = Course::leftJoin('departments', 'courses.department_id', '=', 'departments.id')
                            ->leftJoin('users', 'courses.teacher_id', '=', 'users.id')
                            ->select(
                                'courses.*',
                                'departments.name as department_name',
                                'users.name as teacher_name'
                            )
                            ->when( request('searchKey') ,function($query){
                               $query->whereAny( ['courses.title','courses.description','courses.price','departments.name','users.name'], 'like' , '%'.request('searchKey').'%' );
                            })
                        ->paginate(3);
        return view('Admin.Course.list',compact('courses'));
    }
    // delete course
    public function courseDelete($id){
       $course = Course::where('id', $id)->first();

    // delete image from public/courseImage
    if ($course && $course->image) {
        $imagePath = public_path('/courseImage/' . $course->image);

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // delete course record
    Course::where('id', $id)->delete();

    Alert::success('Success', 'Course deleted successfully');

    return to_route('admin#courseList');
    }

}
