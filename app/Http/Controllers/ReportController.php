<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Department;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ReportController extends Controller
{
    // to admin report page from student and teacher
        public function adminReport()
        {
            $reports = Report::select(
                    'reports.*',
                    'users.name as user_name',
                    'users.role as user_role'
                )
                ->join('users', 'users.id', 'reports.user_id')
                ->orderBy('reports.created_at', 'desc')
                ->get();

            foreach ($reports as $report) {

                // Teacher report → department via course
                if ($report->user_role === 'teacher') {

                    $department = Department::join(
                            'courses',
                            'courses.department_id',
                            'departments.id'
                        )
                        ->where('courses.teacher_id', $report->user_id)
                        ->select('departments.name')
                        ->first();

                    $report->department_name = $department->name ?? 'No Dept';

                }
                // Student report → department via report
                else {

                    $department = Department::where(
                            'id',
                            $report->department_id
                        )
                        ->select('name')
                        ->first();

                    $report->department_name = $department->name ?? 'No Dept';
                }
            }

            return view('Admin.Report.adminReportList', compact('reports'));
        }


    // delete report
    public function deleteReport($id){
       Report::where('id',$id)->delete();

         Alert::success('Success Title', 'delete Admin successully');

         return to_route('admin#dashboard');
    }
}
