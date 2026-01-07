<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AssignmentController extends Controller
{
        // to my assignment
        public function myAssignment()
        {
            $assignments = Assignment::where('assignments.teacher_id', Auth::id())
                ->leftJoin('courses', 'assignments.course_id', '=', 'courses.id')
                ->select('assignments.*', 'courses.title as course_title')
                ->when(request('searchKey'), function ($query) {
                    $query->where('assignments.task', 'like', '%' . request('searchKey') . '%');
                })
                ->paginate(5);

            return view('Teacher.Assignment.myAssignment', compact('assignments'));
        }



    // Create Assignment Page
    public function createAssignmentPage()
    {
        $courses = Course::select('id', 'title')
            ->where('teacher_id', Auth::user()->id)
            ->get();

        return view('Teacher.Assignment.createAssignmentPage', compact('courses'));
    }

    // Create Assignment
    public function createAssignment(Request $request)
    {
        $this->checkAssignmentValidation($request);

        $data = $this->getAssignmentData($request);

        Assignment::create($data);

        Alert::success('Success', 'Assignment created successfully');

        return to_route('teacher#myAssignment');
    }

    // delete assignment
    public function deleteAssignment($id){
      Assignment::where('id',$id)->delete();

      Alert::success('Success', 'Assignment deleted successfully');

      return to_route('teacher#myAssignment');
    }

    // Validation
    private function checkAssignmentValidation($request)
    {
        $request->validate([
            'course_id' => 'required',
            'task'      => 'required',
        ]);
    }
    // Data Preparation
    private function getAssignmentData($request)
    {
        return [
            'teacher_id' => Auth::user()->id,
            'course_id'  => $request->course_id,
            'task'       => $request->task,
        ];
    }

}
