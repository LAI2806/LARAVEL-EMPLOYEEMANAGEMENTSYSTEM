<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;

class AttendanceServices
{
    public function markAbsent()
    {
        $today = Carbon::today();

        $employees = Employee::whereHas('user', function ($q) {
            $q->where('role', 'employee');
        })->get();

        foreach ($employees as $emp) {

            $attendance = Attendance::where('employee_id', $emp->id)
                ->whereDate('attendance_date', $today)
                ->first();

            if (!$attendance) {
                Attendance::create([
                    'employee_id' => $emp->id,
                    'attendance_date' => $today,
                    'status' => 'Absent'
                ]);
            }
        }
    }
}