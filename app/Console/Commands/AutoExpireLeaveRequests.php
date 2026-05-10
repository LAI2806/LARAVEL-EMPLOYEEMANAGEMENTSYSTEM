<?php
namespace App\Console\Commands;

use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoExpireLeaveRequests extends Command
{
    protected $signature = 'leave:auto-expire';
    protected $description = 'Auto-expire pending leave requests whose start date has passed';

    public function handle()
    {
        LeaveRequest::where('status', 'pending')
            ->whereDate('start_date', '<=', Carbon::today()) // changed < to <=
            ->update([
                'status'      => 'rejected',
                'approved_by' => null,    
            ]);

        $this->info('Expired leave requests updated.');
    }
}