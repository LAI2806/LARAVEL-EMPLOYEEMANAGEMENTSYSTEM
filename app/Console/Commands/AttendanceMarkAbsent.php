<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceMarkAbsent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:mark-absent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
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
                'employee_id' => $employee->id,
                'attendance_date' => $date,
                'status' => 'Absent',
                'time_in' => null,
                'time_out' => null
            ]);
        }
    }

    $this->info('Absent records checked.');
}
}
