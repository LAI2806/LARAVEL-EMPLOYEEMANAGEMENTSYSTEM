<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user  = Auth::user();
        $role  = $user->role;
        $month = $request->get('month', Carbon::now()->month);
        $year  = $request->get('year',  Carbon::now()->year);

        // ── ADMIN / HR ─────────────────────────────────────────────
        if (in_array($role, ['admin', 'hr'])) {

            $totalEmployees    = Employee::count();
            $activeEmployees   = Employee::where('employment_status', 'active')->count();
            $newHiresThisMonth = Employee::whereMonth('hire_date', $month)
                                         ->whereYear('hire_date', $year)->count();

            $presentThisMonth  = Attendance::whereMonth('attendance_date', $month)
                                           ->whereYear('attendance_date', $year)
                                           ->where('status', 'Present')->count();
            $lateThisMonth     = Attendance::whereMonth('attendance_date', $month)
                                           ->whereYear('attendance_date', $year)
                                           ->where('status', 'Late')->count();
            $absentThisMonth   = Attendance::whereMonth('attendance_date', $month)
                                           ->whereYear('attendance_date', $year)
                                           ->where('status', 'Absent')->count();

            $totalLeaves    = LeaveRequest::whereMonth('start_date', $month)
                                          ->whereYear('start_date', $year)->count();
            $approvedLeaves = LeaveRequest::whereMonth('start_date', $month)
                                          ->whereYear('start_date', $year)
                                          ->where('status', 'approved')->count();
            $pendingLeaves  = LeaveRequest::whereMonth('start_date', $month)
                                          ->whereYear('start_date', $year)
                                          ->where('status', 'pending')->count();
            $rejectedLeaves = LeaveRequest::whereMonth('start_date', $month)
                                          ->whereYear('start_date', $year)
                                          ->where('status', 'rejected')->count();

            $departments    = Department::withCount('employees')->get();
            $leaveList      = LeaveRequest::with('employee')
                                          ->whereMonth('start_date', $month)
                                          ->whereYear('start_date', $year)
                                          ->latest()->get();
            $employeeList   = Employee::with('department')->latest()->get();
            $attendanceList = Attendance::with('employee.department')
                                        ->whereMonth('attendance_date', $month)
                                        ->whereYear('attendance_date', $year)
                                        ->latest('attendance_date')->get();

            return view('reports.index', compact(
                'month', 'year', 'role',
                'totalEmployees', 'activeEmployees', 'newHiresThisMonth',
                'presentThisMonth', 'lateThisMonth', 'absentThisMonth',
                'totalLeaves', 'approvedLeaves', 'pendingLeaves', 'rejectedLeaves',
                'departments', 'leaveList', 'employeeList', 'attendanceList'
            ));
        }

        // ── MANAGER ────────────────────────────────────────────────
        if ($role === 'manager') {
            $department  = Department::where('manager_id', $user->id)->first();
            $deptId      = $department?->id;

            $employeeList = Employee::with('department')
                                    ->where('department_id', $deptId)
                                    ->latest()->get();

            $employeeIds = $employeeList->pluck('id');

            $presentThisMonth = Attendance::whereIn('employee_id', $employeeIds)
                                          ->whereMonth('attendance_date', $month)
                                          ->whereYear('attendance_date', $year)
                                          ->where('status', 'Present')->count();
            $lateThisMonth    = Attendance::whereIn('employee_id', $employeeIds)
                                          ->whereMonth('attendance_date', $month)
                                          ->whereYear('attendance_date', $year)
                                          ->where('status', 'Late')->count();
            $absentThisMonth  = Attendance::whereIn('employee_id', $employeeIds)
                                          ->whereMonth('attendance_date', $month)
                                          ->whereYear('attendance_date', $year)
                                          ->where('status', 'Absent')->count();

            $attendanceList = Attendance::with('employee')
                                        ->whereIn('employee_id', $employeeIds)
                                        ->whereMonth('attendance_date', $month)
                                        ->whereYear('attendance_date', $year)
                                        ->latest('attendance_date')->get();

            $leaveList      = LeaveRequest::with('employee')
                                          ->whereIn('employee_id', $employeeIds)
                                          ->whereMonth('start_date', $month)
                                          ->whereYear('start_date', $year)
                                          ->latest()->get();

            $totalLeaves    = $leaveList->count();
            $approvedLeaves = $leaveList->where('status', 'approved')->count();
            $pendingLeaves  = $leaveList->where('status', 'pending')->count();
            $rejectedLeaves = $leaveList->where('status', 'rejected')->count();

            return view('reports.index', compact(
                'month', 'year', 'role', 'department',
                'employeeList', 'attendanceList', 'leaveList',
                'presentThisMonth', 'lateThisMonth', 'absentThisMonth',
                'totalLeaves', 'approvedLeaves', 'pendingLeaves', 'rejectedLeaves'
            ));
        }

        // ── EMPLOYEE ───────────────────────────────────────────────
        if ($role === 'employee') {
            $employee = $user->employee;

            $myAttendance = Attendance::where('employee_id', $employee?->id)
                                      ->whereMonth('attendance_date', $month)
                                      ->whereYear('attendance_date', $year)
                                      ->latest('attendance_date')->get();

            $presentCount = $myAttendance->where('status', 'Present')->count();
            $lateCount    = $myAttendance->where('status', 'Late')->count();
            $absentCount  = $myAttendance->where('status', 'Absent')->count();

            $myLeaves = LeaveRequest::where('employee_id', $employee?->id)
                                    ->whereMonth('start_date', $month)
                                    ->whereYear('start_date', $year)
                                    ->latest()->get();

            $totalLeaves    = $myLeaves->count();
            $approvedLeaves = $myLeaves->where('status', 'approved')->count();
            $pendingLeaves  = $myLeaves->where('status', 'pending')->count();
            $rejectedLeaves = $myLeaves->where('status', 'rejected')->count();

            return view('reports.index', compact(
                'month', 'year', 'role', 'employee',
                'myAttendance', 'presentCount', 'lateCount', 'absentCount',
                'myLeaves', 'totalLeaves', 'approvedLeaves', 'pendingLeaves', 'rejectedLeaves'
            ));
        }

        abort(403);
    }
}