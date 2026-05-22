<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();

        switch ($user->role) {
            case 'admin':
                return $this->adminDashboard($today);

            case 'hr':
                return $this->hrDashboard($today);

            case 'manager':
                return $this->managerDashboard($user, $today);

            case 'employee':
                return $this->employeeDashboard($user, $today);

            default:
                abort(403, 'Unauthorized role.');
        }
    }

    private function adminDashboard(Carbon $today)
    {
        $data = [
            'totalEmployees'      => Employee::count(),
            'totalDepartments'    => Department::count(),
            'totalUsers'          => User::count(),
            'presentToday'        => Attendance::whereDate('attendance_date', $today)
                                        ->where('status', 'Present')
                                        ->count(),
            'pendingLeaves'       => LeaveRequest::where('status', 'pending')->count(),
            'absentToday'         => Attendance::whereDate('attendance_date', $today)
                                        ->where('status', 'Absent')
                                        ->count(),
            'lateToday'           => Attendance::whereDate('attendance_date', $today)
                                        ->where('status', 'Late')
                                        ->count(),
            'recentActivities'    => LeaveRequest::with('employee')
                                        ->latest()
                                        ->take(8)
                                        ->get(),
            'departmentSummary'   => Department::withCount('employees')->get(),
            'usersByRole'         => User::selectRaw('role, count(*) as count')
                                        ->groupBy('role')
                                        ->pluck('count', 'role'),
        ];

        return view('dashboard.admin', $data);
    }

    private function hrDashboard(Carbon $today)
    {
        $data = [
            'totalEmployees'   => Employee::count(),
            'totalDepartments' => Department::count(),
            'presentToday'     => Attendance::whereDate('attendance_date', $today)
                                    ->where('status', 'Present')
                                    ->count(),
            'absentToday'      => Attendance::whereDate('attendance_date', $today)
                                    ->where('status', 'Absent')
                                    ->count(),
            'lateToday'        => Attendance::whereDate('attendance_date', $today)
                                    ->where('status', 'Late')
                                    ->count(),
            'pendingLeaves'    => LeaveRequest::where('status', 'pending')->count(),
            'approvedLeaves'   => LeaveRequest::where('status', 'approved')
                                    ->whereMonth('start_date', $today->month)
                                    ->count(),
            'recentLeaves'     => LeaveRequest::with('employee')
                                    ->where('status', 'pending')
                                    ->latest()
                                    ->take(6)
                                    ->get(),
            'newHiresThisMonth'=> Employee::whereMonth('hire_date', $today->month)
                                    ->whereYear('hire_date', $today->year)
                                    ->count(),
            'departmentList'   => Department::withCount('employees')->get(),
        ];

        return view('dashboard.hr', $data);
    }

    private function managerDashboard(User $user, Carbon $today)
    {

        $department = Department::where('manager_id', $user->id)->first();
        $employeeIds = $department
            ? Employee::where('department_id', $department->id)->pluck('id')
            : collect();

        $data = [
            'department'       => $department,
            'teamCount'        => $employeeIds->count(),
            'presentToday'     => Attendance::whereIn('employee_id', $employeeIds)
                                    ->whereDate('attendance_date', $today)
                                    ->where('status', 'Present')
                                    ->count(),
            'absentToday'      => Attendance::whereIn('employee_id', $employeeIds)
                                    ->whereDate('attendance_date', $today)
                                    ->where('status', 'Absent')
                                    ->count(),
            'lateToday'        => Attendance::whereIn('employee_id', $employeeIds)
                                    ->whereDate('attendance_date', $today)
                                    ->where('status', 'Late')
                                    ->count(),
            'pendingLeaves'    => LeaveRequest::whereIn('employee_id', $employeeIds)
                                    ->where('status', 'pending')
                                    ->count(),
            'pendingLeaveList' => LeaveRequest::with('employee')
                                    ->whereIn('employee_id', $employeeIds)
                                    ->where('status', 'pending')
                                    ->latest()
                                    ->take(6)
                                    ->get(),
            'teamAttendance'   => Attendance::with('employee')
                                    ->whereIn('employee_id', $employeeIds)
                                    ->whereDate('attendance_date', $today)
                                    ->get(),
        ];

        return view('dashboard.manager', $data);
    }

    private function employeeDashboard(User $user, Carbon $today)
    {
        $employee = Employee::where('user_id', $user->id)->first();

        $data = [
            'employee'          => $employee,
            'todayAttendance'   => $employee
                                    ? Attendance::where('employee_id', $employee->id)
                                        ->whereDate('attendance_date', $today)
                                        ->first()
                                    : null,
            'attendanceHistory' => $employee
                                    ? Attendance::where('employee_id', $employee->id)
                                        ->latest('attendance_date')
                                        ->take(7)
                                        ->get()
                                    : collect(),
            'myLeaveRequests'   => $employee
                                    ? LeaveRequest::where('employee_id', $employee->id)
                                        ->latest()
                                        ->take(5)
                                        ->get()
                                    : collect(),
            'pendingLeaves'     => $employee
                                    ? LeaveRequest::where('employee_id', $employee->id)
                                        ->where('status', 'pending')
                                        ->count()
                                    : 0,
            'approvedLeaves'    => $employee
                                    ? LeaveRequest::where('employee_id', $employee->id)
                                        ->where('status', 'approved')
                                        ->count()
                                    : 0,
            'presentDaysMonth'  => $employee
                                    ? Attendance::where('employee_id', $employee->id)
                                        ->whereMonth('attendance_date', $today->month)
                                        ->where('status', 'Present')
                                        ->count()
                                    : 0,
        ];

        return view('dashboard.employee', $data);
    }

    public function employee(Employee $employee)
    {
        return $this->index(request()); 
    }

    
    public function manager(User $user)
    {
        return $this->index(request()); 
    }
}