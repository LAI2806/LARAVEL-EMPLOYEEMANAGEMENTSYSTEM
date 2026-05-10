<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Services\AttendanceService;

Schedule::command('attendance:mark-absent')->dailyAt('00:05');
Schedule::command('leave:auto-expire')->dailyAt('00:01');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
