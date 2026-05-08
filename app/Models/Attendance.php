<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Employee;
use Carbon\Carbon;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'attendance_date',
        'time_in',
        'time_out',
        'status',
        'remarks'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function getHoursWorkedAttribute()
    {
        if ($this->time_in && $this->time_out) {
            return round(
                Carbon::parse($this->time_in)
                    ->floatDiffInHours(Carbon::parse($this->time_out)),
                2
            );
        }

        return 0;
    }

}
