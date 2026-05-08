@extends('layouts.app')

@section('content')

<h4 class="fw-bold mb-1">Dashboard</h4>
<p class="text-muted mb-4" style="font-size:13px;">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>

@if(!$employee)
<div class="alert d-flex align-items-center gap-3" style="background:#fef3c7;border:1px solid #fcd34d;border-radius:var(--radius);color:#92400e;">
    <i class="bi bi-exclamation-triangle-fill" style="font-size:20px;"></i>
    <div>
        <strong>Profile Not Linked</strong><br>
        <span style="font-size:13px;">Your account is not yet linked to an employee profile. Please contact HR.</span>
    </div>
</div>
@else

{{-- Profile banner --}}
<div class="p-4 mb-4 rounded-3 d-flex align-items-center gap-4"
     style="background:#ffffff;color:#1a1a2e;">
    <div style="width:60px;height:60px;border-radius:50%;background:var(--brand-accent);
                display:flex;align-items:center;justify-content:center;
                font-size:24px;font-weight:700;flex-shrink:0;">
        {{ strtoupper(substr($employee->first_name, 0, 1)) }}
    </div> 
    <div style="flex:1;">
        <div style="font-size:22px;font-weight:700;margin-bottom:2px;">{{ $employee->full_name }}</div>
        <div style="font-size:13px;color:#94a3b8;">
            {{ $employee->position }} &nbsp;·&nbsp; {{ $employee->department?->name ?? 'No Department' }}
        </div>
        <div style="font-weight:600;font-size:12px;color:#64748b;margin-top:4px;">
            <i class="bi bi-calendar3"></i>    Hired: {{ \Carbon\Carbon::parse($employee->hire_date)->format('F j, Y') }}
        </div>
    </div>
    {{-- Today clock status --}}
    <div class="text-end d-none d-md-block">
        @if($todayAttendance)
            <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.8px;">Today</div>
            <div style="font-size:13px;font-family:'DM Mono',monospace;color:#e2e8f0;">
                In: {{ $todayAttendance->time_in ? \Carbon\Carbon::parse($todayAttendance->time_in)->format('h:i A') : '—' }}
            </div>
            <div style="font-size:13px;font-family:'DM Mono',monospace;color:#e2e8f0;">
                Out: {{ $todayAttendance->time_out ? \Carbon\Carbon::parse($todayAttendance->time_out)->format('h:i A') : '—' }}
            </div>
            <span class="badge-status badge-{{ strtolower(str_replace(' ','-',$todayAttendance->status)) }}" style="margin-top:4px;font-size:11px;">
                {{ $todayAttendance->status }}
            </span>
        @else
            <div style="font-size:12px;color:#64748b;">No attendance<br>recorded today</div>
        @endif
    </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="stat-card" style="display:flex;align-items:center;gap:16px;">
            <div class="stat-icon icon-green" style="margin-bottom:0;flex-shrink:0;">
                <i class="bi bi-calendar2-check-fill"></i>
            </div>
            <div>
                <div class="stat-value">{{ $presentDaysMonth }}</div>
                <div class="stat-label">Present Days (This Month)</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4">
        <div class="stat-card" style="display:flex;align-items:center;gap:16px;">
            <div class="stat-icon icon-amber" style="margin-bottom:0;flex-shrink:0;">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div>
                <div class="stat-value">{{ $pendingLeaves }}</div>
                <div class="stat-label">Pending Leave Requests</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4">
        <div class="stat-card" style="display:flex;align-items:center;gap:16px;">
            <div class="stat-icon icon-indigo" style="margin-bottom:0;flex-shrink:0;">
                <i class="bi bi-check2-circle"></i>
            </div>
            <div>
                <div class="stat-value">{{ $approvedLeaves }}</div>
                <div class="stat-label">Approved Leaves</div>
            </div>
        </div>
    </div>
</div>

{{-- Quick actions --}}
<div class="data-card mb-4">
    <div class="data-card-header">
        <span class="data-card-title"><i class="bi bi-lightning me-2 text-warning"></i>Quick Actions</span>
    </div>
    <div class="p-3 d-flex flex-wrap gap-2">
        <a href="{{ route('leave.create') }}" style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;background:#6366f1;color:#fff;text-decoration:none;border:none;transition:background .15s;" onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#6366f1'">
            <i class="bi bi-plus-circle"></i> File Leave Request
        </a>
        <a href="{{ route('attendance.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;background:#fff;color:#6366f1;text-decoration:none;border:1px solid #d4d4f5;transition:all .15s;" onmouseover="this.style.background='#f0f0fd'" onmouseout="this.style.background='#fff'">
            <i class="bi bi-calendar-check"></i> My Attendance
        </a>
        <a href="{{ route('leave.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;background:#fff;color:#6366f1;text-decoration:none;border:1px solid #d4d4f5;transition:all .15s;" onmouseover="this.style.background='#f0f0fd'" onmouseout="this.style.background='#fff'">
            <i class="bi bi-file-earmark-text"></i> My Leave Requests
        </a>
    </div>
</div>

<div class="row g-3">

    {{-- Recent attendance --}}
    <div class="col-12 col-xl-6">
        <div class="data-card h-100">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-calendar-week me-2 text-primary"></i>Recent Attendance</span>
                <a href="{{ route('attendance.index') }}" 
                    style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;background:#fff;color:var(--text-muted);border:1px solid var(--border);border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;">
                        Full History
                    </a>
            </div>
            <table class="hris-table">
                <thead>
                    <tr><th>Date</th><th>Time In</th><th>Time Out</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($attendanceHistory as $att)
                    <tr>
                        <td style="font-size:13px;font-weight:600;">
                            {{ \Carbon\Carbon::parse($att->attendance_date)->format('M d, Y') }}
                            <div style="font-size:11px;color:var(--text-muted);">{{ \Carbon\Carbon::parse($att->attendance_date)->format('l') }}</div>
                        </td>
                        <td style="font-family:'DM Mono',monospace;font-size:13px;">
                            {{ $att->time_in ? \Carbon\Carbon::parse($att->time_in)->format('h:i A') : '—' }}
                        </td>
                        <td style="font-family:'DM Mono',monospace;font-size:13px;">
                            {{ $att->time_out ? \Carbon\Carbon::parse($att->time_out)->format('h:i A') : '—' }}
                        </td>
                        <td>
                            <span class="badge-status badge-{{ strtolower(str_replace(' ','-',$att->status)) }}">
                                {{ $att->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">No attendance records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- My leave requests --}}
    <div class="col-12 col-xl-6">
        <div class="data-card h-100">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-file-earmark-text me-2 text-primary"></i>My Leave Requests</span>
                <a href="{{ route('leave.create') }}" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:9px;font-size:12px;font-weight:600;background:#6366f1;color:#fff;text-decoration:none;transition:background .15s;" onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#6366f1'">
                    <i class="bi bi-plus"></i> New
                </a>
            </div>
            <table class="hris-table">
                <thead>
                    <tr><th>Type</th><th>Dates</th><th>Days</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($myLeaveRequests as $leave)
                    <tr>
                        <td style="font-size:13px;font-weight:600;">{{ $leave->leave_type }}</td>
                        <td style="font-size:12px;color:var(--text-muted);">
                            {{ \Carbon\Carbon::parse($leave->start_date)->format('M d') }} – {{ \Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}
                        </td>
                        <td style="font-family:'DM Mono',monospace;font-size:13px;">{{ $leave->duration }}d</td>
                        <td>
                            <span class="badge-status badge-{{ strtolower($leave->status) }}">{{ ucfirst($leave->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="bi bi-file-earmark d-block mb-1" style="font-size:22px;"></i>
                            No leave requests yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endif

@endsection