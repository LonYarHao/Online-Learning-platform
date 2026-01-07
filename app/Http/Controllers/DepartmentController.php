<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DepartmentController extends Controller
{
    // to department page

    public function list(){
        $departments = Department::orderBy('created_at','desc')->paginate(5);
        return view('Admin.Department.department',compact('departments'));
    }

    // create department
    public function create(Request $request){
       $this->checkValidation($request);

       Department::create([
         'name' => $request->name
       ]);
       Alert::success('Success Title', 'Department Created Successfully');

       return back();
    }

    // delete department
    public function delete($id){
        Department::where('id',$id)->delete();
        return back();
    }

    //edit  department
    public function edit($id){
        $department = Department::where('id',$id)->first();
        return view('Admin.Department.edit',compact('department'));
    }

    //update department
    public function update($id,Request $request){
        $request['id'] = $id;
        $this->checkValidation($request);

        Department::where('id',$id)->update([
         'name' => $request->name
        ]);

        Alert::success('Success Title', 'Department updated Successfully');

         return to_route('admin#departmentList');
    }

    // validate department
    private function checkValidation(Request $request){
        $request->validate([
            'name' => 'required|min:2|max:30|unique:departments,name,'.$request->id,
        ],[
            'name.required' => 'Department name is required'
        ]);
    }
}
