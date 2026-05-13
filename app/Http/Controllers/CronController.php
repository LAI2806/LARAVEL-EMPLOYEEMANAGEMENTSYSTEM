<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Carbon\Carbon;

class CronController extends Controller
{
    public function markAbsent(Request $request): JsonResponse
    {
        $date = Carbon::yesterday()->toDateString();

        $employees = Employee::whereHas('user', fn($q) =>
            $q->where('role', 'employee')
        )->get();

        foreach ($employees as $employee) {
            $exists = Attendance::where('employee_id', $employee->id)
                ->whereDate('attendance_date', $date)
                ->exists();

            if (!$exists) {
                Attendance::create([
                    'employee_id'     => $employee->id,
                    'attendance_date' => $date,
                    'status'          => 'Absent',
                    'time_in'         => null,
                    'time_out'        => null,
                ]);
            }
        }

        return response()->json(['status' => 'ok']);
    }

    public function autoExpireLeave(Request $request): JsonResponse
    {
        LeaveRequest::where('status', 'pending')
            ->whereDate('start_date', '<', Carbon::today())
            ->update([
                'status'      => 'rejected',
                'approved_by' => null,
            ]);

        return response()->json(['status' => 'ok']);
    }
}