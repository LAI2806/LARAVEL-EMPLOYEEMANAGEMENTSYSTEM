<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user  = Auth::user();
        $role  = $user->role;
        $month = $request->get('month', Carbon::now()->month);
        $year  = $request->get('year',  Carbon::now()->year);

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

        public function exportCsv(Request $request)
    {
        $user  = Auth::user();
        $role  = $user->role;
        $month = $request->get('month', Carbon::now()->month);
        $year  = $request->get('year',  Carbon::now()->year);
        $type  = $request->get('type', 'attendance');

        $filename = $type . '_' . $year . '_' . str_pad($month, 2, '0', STR_PAD_LEFT) . '.csv';

        return response()->stream(function () use ($user, $role, $month, $year, $type) {
            $handle = fopen('php://output', 'w');

            match ($type) {
                'attendance' => $this->csvAttendance($handle, $user, $role, $month, $year),
                'leave'      => $this->csvLeave($handle, $user, $role, $month, $year),
                'employees'  => $this->csvEmployees($handle),
                'departments'=> $this->csvDepartments($handle),
                'users'      => $this->csvUsers($handle),
                default      => null,
            };

            fclose($handle);
        }, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function csvAttendance($handle, $user, $role, $month, $year)
    {
        fputcsv($handle, ['Employee', 'Department', 'Date', 'Day', 'Time In', 'Time Out', 'Status', 'Hours', 'Remarks']);

        $query = Attendance::with('employee.department')
            ->whereMonth('attendance_date', $month)
            ->whereYear('attendance_date', $year);

        if ($role === 'manager') {
            $dept = Department::where('manager_id', $user->id)->first();
            $ids  = Employee::where('department_id', $dept?->id)->pluck('id');
            $query->whereIn('employee_id', $ids);
        }
        if ($role === 'employee') {
            $query->where('employee_id', $user->employee?->id);
        }

        foreach ($query->latest('attendance_date')->get() as $a) {
            fputcsv($handle, [
                $a->employee?->first_name . ' ' . $a->employee?->last_name,
                $a->employee?->department?->name ?? '—',
                $a->attendance_date,
                Carbon::parse($a->attendance_date)->format('l'),
                $a->time_in  ?? '—',
                $a->time_out ?? '—',
                $a->status,
                $a->hours_worked ?? 0,
                $a->remarks ?? '—',
            ]);
        }
    }

    private function csvLeave($handle, $user, $role, $month, $year)
    {
        fputcsv($handle, ['Employee', 'Department', 'Leave Type', 'Start Date', 'End Date', 'Status', 'Reason']);

        $query = LeaveRequest::with('employee.department')
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year);

        if ($role === 'manager') {
            $dept = Department::where('manager_id', $user->id)->first();
            $ids  = Employee::where('department_id', $dept?->id)->pluck('id');
            $query->whereIn('employee_id', $ids);
        }
        if ($role === 'employee') {
            $query->where('employee_id', $user->employee?->id);
        }

        foreach ($query->latest()->get() as $l) {
            fputcsv($handle, [
                $l->employee?->first_name . ' ' . $l->employee?->last_name,
                $l->employee?->department?->name ?? '—',
                $l->leave_type ?? '—',
                $l->start_date,
                $l->end_date,
                $l->status,
                $l->reason ?? '—',
            ]);
        }
    }

    private function csvEmployees($handle)
    {
        fputcsv($handle, ['ID', 'First Name', 'Last Name', 'Email', 'Phone', 'Position', 'Department', 'Hire Date', 'Status']);

        foreach (Employee::with('department')->latest()->get() as $e) {
            fputcsv($handle, [
                $e->id,
                $e->first_name,
                $e->last_name,
                $e->email,
                $e->phone ?? '—',
                $e->position,
                $e->department?->name ?? '—',
                $e->hire_date,
                $e->employment_status,
            ]);
        }
    }

    private function csvDepartments($handle)
    {
        fputcsv($handle, ['ID', 'Department Name', 'Manager', 'Total Employees']);

        foreach (Department::withCount('employees')->with('manager')->latest()->get() as $d) {
            fputcsv($handle, [
                $d->id,
                $d->name,
                $d->manager?->name ?? '—',
                $d->employees_count,
            ]);
        }
    }

    private function csvUsers($handle)
    {
        fputcsv($handle, ['ID', 'Name', 'Email', 'Role', 'Created At']);

        foreach (User::latest()->get() as $u) {
            fputcsv($handle, [
                $u->id,
                $u->name,
                $u->email,
                $u->role,
                $u->created_at->format('Y-m-d'),
            ]);
        }
    }

}