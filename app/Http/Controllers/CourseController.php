<?php

namespace App\Http\Controllers;


use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CourseController extends Controller
{
    // to teacher create course page
    public function createCoursePage(){
        $departments = Department::select('id','name')->get();
        return view('Teacher.Course.createPage',compact('departments'));
    }
    // creating course
public function createCourse(Request $request)
{
    $this->checkValidation($request);

    $data = $this->getCourseData($request);

    // Handle image upload
    if ($request->hasFile('image')) {
        $fileName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('/courseImage/'), $fileName);
        $data['image'] = $fileName;
    }

    Course::create($data);

    Alert::success('Success Title', 'Course Created successully');

    return to_route('teacher#dashboard');
}

public function myCourses(){
    $courses = Course::where('courses.teacher_id', Auth::user()->id)
        ->leftJoin('departments', 'courses.department_id', '=', 'departments.id')
        ->select('courses.*', 'departments.name as department_name')
        ->when( request('searchKey') ,function($query){
                        $query->whereAny( ['courses.title','courses.description','courses.price'], 'like' , '%'.request('searchKey').'%' );
                    })
        ->paginate(3);

    // dd($courses);

    return view('Teacher.Course.myCourse', compact('courses'));
}

public function editCourse($id){
    $course = Course::where('id', $id)
        ->where('teacher_id', Auth::id()) // security
        ->first();

    $departments = Department::get();

    return view('Teacher.Course.editCourse', compact('course', 'departments'));
}
public function updateCourse(Request $request)
{
    // Validation
    $request->validate([
        'course_id' => 'required|exists:courses,id',
        'title' => 'required|string|max:255',
        'department_id' => 'required|exists:departments,id',
        'price' => 'required|numeric|min:0',
        'description' => 'required|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Get course securely
    $course = Course::where('id', $request->course_id)
        ->where('teacher_id', Auth::id())
        ->first();

    // Prepare data
    $data = $request->except('course_id', 'image');

    // Handle image update
    if ($request->hasFile('image')) {

        // Delete old image
        if ($course->image && file_exists(public_path('/courseImage/' . $course->image))) {
            unlink(public_path('/courseImage/' . $course->image));
        }

        // Save new image
        $fileName = uniqid() . '.' . $request->image->extension();
        $request->image->move(public_path('/courseImage/'), $fileName);
        $data['image'] = $fileName;
    } else {
        $data['image'] = $course->image; // keep old image
    }

    // Update course
    $course->update($data);

   Alert::success('Success Title', 'Courses updated Successfully');

         return to_route('teacher#myCourses');
}



// validation
private function checkValidation($request)
{
    $request->validate([
        'title'         => 'required|unique:courses,title,',
        'departmentId'  => 'required',
        'price'         => 'required|numeric|min:0',
        'description'   => 'required',
        'image'         => 'required|mimes:jpg,jpeg,png|max:2048',
    ]);
}


// prepare data
private function getCourseData($request)
{
    return [
        'title'         => $request->title,
        'department_id' => $request->departmentId,
        'price'         => $request->price,
        'description'   => $request->description,
        'teacher_id'    => auth()->user()->id,
    ];
}

}
