@extends('layouts.app')

@section('content')

<h4 class="fw-bold mb-1">Manager Dashboard</h4>
<p class="text-muted mb-4" style="font-size:13px;">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>

@if(!$department)
<div class="alert d-flex align-items-center gap-3" style="background:#fef3c7;border:1px solid #fcd34d;border-radius:var(--radius);color:#92400e;">
    <i class="bi bi-exclamation-triangle-fill" style="font-size:20px;"></i>
    <div>
        <strong>No Department Assigned</strong><br>
        <span style="font-size:13px;">You are not currently assigned as a manager for any department. Please contact your HR administrator.</span>
    </div>
</div>
@else

{{-- Dept banner --}}
<div class="p-4 mb-4 rounded-3 d-flex align-items-center justify-content-between"
     style="background:#ffffff;border:1px solid #e2e8f0;box-shadow:0 2px 16px rgba(15,23,42,0.07);">
    <div>
        <div style="font-size:11px;font-weight:700;letter-spacing:1px;color:#a0a3b8;text-transform:uppercase;">Your Department</div>
        <div style="font-size:24px;font-weight:700;margin-bottom:4px;color:#1a1a2e;">{{ $department->name }}</div>
        @if($department->description)
            <div style="font-size:13px;color:#a0a3b8;">{{ $department->description }}</div>
        @endif
    </div>
    <div class="text-end">
        <div style="font-size:34px;font-weight:700;font-family:'DM Mono',monospace;color:#6366f1;">{{ $teamCount }}</div>
        <div style="font-size:13px;color:#a0a3b8;">Team Members</div>
    </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card" style="display:flex;align-items:center;gap:16px;">
            <div class="stat-icon icon-green" style="margin-bottom:0;flex-shrink:0;">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div>
                <div class="stat-value">{{ $presentToday }}</div>
                <div class="stat-label">Present Today</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="display:flex;align-items:center;gap:16px;">
            <div class="stat-icon icon-amber" style="margin-bottom:0;flex-shrink:0;">
                <i class="bi bi-clock-fill"></i>
            </div>
            <div>
                <div class="stat-value">{{ $lateToday }}</div>
                <div class="stat-label">Late Today</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="display:flex;align-items:center;gap:16px;">
            <div class="stat-icon icon-red" style="margin-bottom:0;flex-shrink:0;">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <div>
                <div class="stat-value">{{ $absentToday }}</div>
                <div class="stat-label">Absent Today</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="display:flex;align-items:center;gap:16px;">
            <div class="stat-icon icon-indigo" style="margin-bottom:0;flex-shrink:0;">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div>
                <div class="stat-value">{{ $pendingLeaves }}</div>
                <div class="stat-label">Pending Leaves</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">

    {{-- Pending leave approvals --}}
    <div class="col-12 col-xl-6">
        <div class="data-card h-100">
            <div class="data-card-header">
                <span class="data-card-title">
                    <i class="bi bi-file-earmark-check me-2 text-warning"></i>
                    Leave Approvals
                    @if($pendingLeaves > 0)
                        <span style="display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;border-radius:50%;background:#f59e0b;color:#fff;font-size:11px;font-weight:700;margin-left:6px;">{{ $pendingLeaves }}</span>
                    @endif
                </span>
                <a href="{{ route('leave.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:9px;font-size:12px;font-weight:600;background:#fff;color:#6366f1;text-decoration:none;border:1px solid #d4d4f5;transition:all .15s;" onmouseover="this.style.background='#f0f0fd'" onmouseout="this.style.background='#fff'">
                    All Requests
                </a>
            </div>
            <table class="hris-table">
                <thead>
                    <tr><th>Employee</th><th>Type / Dates</th><th>Action</th></tr>
                </thead>
                <tbody>
                    @forelse($pendingLeaveList as $leave)
                    <tr>
                        <td>
                            <div class="emp-info">
                                <div class="emp-avatar">{{ strtoupper(substr($leave->employee?->first_name ?? '?', 0, 1)) }}</div>
                                <div>
                                    <div class="emp-name">{{ $leave->employee?->full_name ?? $leave->employee?->first_name . ' ' . $leave->employee?->last_name }}</div>
                                    <div class="emp-pos">{{ $leave->employee?->position ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:12px;color:var(--text-muted);">
                            {{ \Carbon\Carbon::parse($leave->start_date)->format('M d') }} – {{ \Carbon\Carbon::parse($leave->end_date)->format('M d') }}<br>
                            <span style="font-family:'DM Mono',monospace;">{{ $leave->duration }}d</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <form method="POST" action="{{ route('leave.approve', $leave->id) }}">
                                    @csrf
                                    <button style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;background:#f0fdf4;color:#10b981;border:1px solid #bbf7d0;cursor:pointer;transition:all .15s;" onmouseover="this.style.background='#dcfce7'" onmouseout="this.style.background='#f0fdf4'" title="Approve">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('leave.reject', $leave->id) }}">
                                    @csrf
                                    <button style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;background:#fff5f5;color:#ef4444;border:1px solid #fecaca;cursor:pointer;transition:all .15s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fff5f5'" title="Reject">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">
                            <i class="bi bi-check2-all d-block mb-1" style="font-size:22px;"></i>
                            All caught up!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Today's team attendance --}}
    <div class="col-12 col-xl-6">
        <div class="data-card h-100">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-calendar-day me-2" style="color:#6366f1;"></i>Today's Attendance</span>
                <a href="{{ route('attendance.team') }}" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:9px;font-size:12px;font-weight:600;background:#fff;color:#6366f1;text-decoration:none;border:1px solid #d4d4f5;transition:all .15s;" onmouseover="this.style.background='#f0f0fd'" onmouseout="this.style.background='#fff'">
                    Full Log
                </a>
            </div>
            <table class="hris-table">
                <thead>
                    <tr><th>Employee</th><th>Time In</th><th>Time Out</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($teamAttendance as $att)
                    <tr>
                        <td>
                            <div class="emp-info">
                                <div class="emp-avatar">{{ strtoupper(substr($att->employee?->first_name ?? '?', 0, 1)) }}</div>
                                <div class="emp-name">{{ $att->employee?->user?->name?? $att->employee?->first_name ?? $att->employee?->last_name}}</div>
                            </div>
                        </td>
                        <td style="font-family:'DM Mono',monospace;font-size:13px;">
                            {{ $att->time_in ? \Carbon\Carbon::parse($att->time_in)->format('h:i A') : '—' }}
                        </td>
                        <td style="font-family:'DM Mono',monospace;font-size:13px;">
                            {{ $att->time_out ? \Carbon\Carbon::parse($att->time_out)->format('h:i A') : '—' }}
                        </td>
                        <td>
                            <span class="badge-status badge-{{ strtolower(str_replace(' ', '-', $att->status)) }}">
                                {{ $att->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">No attendance recorded yet today.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endif

@endsection