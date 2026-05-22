<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AttendanceController extends Controller
{
public function report(Request $request)
{
    $query = Attendance::with(['employee.user', 'employee.department']);

    if ($request->date) {
        $query->whereDate('attendance_date', $request->date);
    }

    if ($request->employee) {
        $query->whereHas('employee.user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->employee . '%');
        });
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $attendances = $query->latest()->get();

    return view('attendance.report', compact('attendances'));
}

    public function index(Request $request)
    {
        $employeeId = Auth::user()->employeeDetails->id;

        $attendanceToday = Attendance::where('employee_id', $employeeId)
            ->whereDate('attendance_date', today())
            ->first();

        $query = Attendance::where('employee_id', $employeeId);

        if ($request->date) {
            $query->whereDate('attendance_date', $request->date);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('attendance_date', 'desc')->get();

        return view('attendance.index', compact('attendanceToday', 'attendances'));
    }

    public function timeIn()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $attendance = Attendance::firstOrCreate([
            'employee_id' => $user->employeeDetails->id,
            'attendance_date' => $today,
        ]);

        if (in_array($attendance->status, ['Absent', 'On Leave'])) {
        return back()->with('error', 'You are marked as ' . $attendance->status . '. Time out not allowed.');
        }

        if ($attendance->time_in) {
            return back()->with('error', 'Already timed in today.');
        }

        $now = Carbon::now();
        $cutoff = Carbon::today()->setTime(8, 15, 0);

        $attendance->time_in = $now;
        $attendance->status = $now->gt($cutoff) ? 'Late' : 'Present';
        $attendance->save();

        return back()->with('success', 'Time In recorded.');
    }

    public function timeOut()
    {
        $user = Auth::user();

        $attendance = Attendance::where('employee_id', $user->employeeDetails->id)
            ->whereDate('attendance_date', Carbon::today())
            ->first();

        if (!$attendance) {
            return back()->with('error', 'No attendance record found.');
        }

        if (in_array($attendance->status, ['Absent', 'On Leave'])) {
            return back()->with('error', 'You are marked as ' . $attendance->status . '. Time out not allowed.');
        }

        if (!$attendance->time_in) {
            return back()->with('error', 'You must time in first.');
        }

        if ($attendance->time_out) {
            return back()->with('error', 'Already timed out.');
        }

        $attendance->time_out = Carbon::now();

        $hours = round(
            Carbon::parse($attendance->time_in)
                ->floatDiffInHours($attendance->time_out),
            2
        );

        if ($hours < 7.75) {
            $attendance->remarks = 'Undertime';
        } elseif ($hours > 8.25) {
            $attendance->remarks = 'Overtime';
        } else {
            $attendance->remarks = 'Complete';
        }

        $attendance->save();

        return back()->with('success', 'Time Out recorded.');
    }

        public function team(Request $request)
    {
        $managerDepartmentId = Auth::user()->employeeDetails->department_id;

        $query = Attendance::whereHas('employee', function ($q) use ($managerDepartmentId) {
            $q->where('department_id', $managerDepartmentId);
        })->with(['employee.user', 'employee.department']);

        if ($request->date) {
            $query->whereDate('attendance_date', $request->date);
        }

        if ($request->employee) {
            $query->whereHas('employee.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->employee . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $presentCount = (clone $query)->where('status', 'Present')->count();
        $lateCount    = (clone $query)->where('status', 'Late')->count();
        $absentCount  = (clone $query)->where('status', 'Absent')->count();
        $onLeaveCount = (clone $query)->where('status', 'On Leave')->count();

        $attendances = $query->latest()->get();

        return view('attendance.team', compact(
            'attendances',
            'presentCount',
            'lateCount',
            'absentCount',
            'onLeaveCount'
        ));
    }
    public function edit(Attendance $attendance)
    {
        $employees = Employee::with('user')->get();
        return view('attendance.edit', compact('attendance', 'employees'));
    }


     public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'status'          => 'required|in:Present,Late,Absent,On Leave',
            'attendance_date' => 'required|date',   // ← ADD THIS LINE ONLY
            'time_in'         => 'nullable|date_format:H:i',
            'time_out'        => 'nullable|date_format:H:i',
            'remarks'         => 'nullable|string|max:255',
        ]);

        if ($request->time_in && $request->time_out) {
        if ($request->time_out <= $request->time_in) {
            return back()
                ->withInput()
                ->withErrors(['time_out' => 'Time out must be after time in.']);
        }
    }

        $attendance->status   = $request->status;
        $attendance->attendance_date = $request->attendance_date;
        $attendance->time_in  = $request->time_in
            ? Carbon::parse($attendance->attendance_date . ' ' . $request->time_in)
            : null;
        $attendance->time_out = $request->time_out
            ? Carbon::parse($attendance->attendance_date . ' ' . $request->time_out)
            : null;
        $attendance->remarks  = $request->remarks;
        $attendance->save();

        return redirect()->route('attendance.report')
            ->with('success', 'Attendance record updated.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return back()->with('success', 'Attendance record deleted.');
    }
}