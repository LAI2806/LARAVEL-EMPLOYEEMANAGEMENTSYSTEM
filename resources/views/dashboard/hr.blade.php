@extends('layouts.app')

@section('content')

<h4 class="fw-bold mb-1">HR Dashboard</h4>
<p class="text-muted mb-4" style="font-size:13px;">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>

{{-- ── Stats ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-indigo"><i class="bi bi-people-fill"></i></div>
            <div class="stat-value">{{ $totalEmployees }}</div>
            <div class="stat-label">Total Employees</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="bi bi-diagram-3-fill"></i></div>
            <div class="stat-value">{{ $totalDepartments }}</div>
            <div class="stat-label">Departments</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="bi bi-person-check-fill"></i></div>
            <div class="stat-value">{{ $newHiresThisMonth }}</div>
            <div class="stat-label">New Hires This Month</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-amber"><i class="bi bi-hourglass-split"></i></div>
            <div class="stat-value">{{ $pendingLeaves }}</div>
            <div class="stat-label">Pending Leaves</div>
        </div>
    </div>
</div>

{{-- Attendance today --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon icon-green" style="margin:0;flex-shrink:0;"><i class="bi bi-check-circle-fill"></i></div>
            <div>
                <div class="stat-value" style="font-size:22px;">{{ $presentToday }}</div>
                <div class="stat-label">Present Today</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon icon-amber" style="margin:0;flex-shrink:0;"><i class="bi bi-clock-fill"></i></div>
            <div>
                <div class="stat-value" style="font-size:22px;">{{ $lateToday }}</div>
                <div class="stat-label">Late Today</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon icon-red" style="margin:0;flex-shrink:0;"><i class="bi bi-x-circle-fill"></i></div>
            <div>
                <div class="stat-value" style="font-size:22px;">{{ $absentToday }}</div>
                <div class="stat-label">Absent Today</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">

    {{-- Pending leave requests with approve/reject --}}
    <div class="col-12 col-xl-7">
        <div class="data-card h-100">
            <div class="data-card-header">
                <span class="data-card-title">
                    <i class="bi bi-file-earmark-text me-2 text-warning"></i>
                    Pending Leave Requests
                    @if($pendingLeaves > 0)
                        <span style="display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;border-radius:50%;background:#f59e0b;color:#fff;font-size:11px;font-weight:700;margin-left:6px;">{{ $pendingLeaves }}</span>
                    @endif
                </span>
                <a href="{{ route('leave.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:9px;font-size:12px;font-weight:600;background:#fff;color:#6366f1;text-decoration:none;border:1px solid #d4d4f5;transition:all .15s;" onmouseover="this.style.background='#f0f0fd'" onmouseout="this.style.background='#fff'">
                    View All
                </a>
            </div>
            <table class="hris-table">
                <thead>
                    <tr><th>Employee</th><th>Type</th><th>Dates</th><th>Days</th><th>Action</th></tr>
                </thead>
                <tbody>
                    @forelse($recentLeaves as $leave)
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
                        <td style="font-size:13px;">{{ $leave->leave_type }}</td>
                        <td style="font-size:12px;color:var(--text-muted);">
                            {{ \Carbon\Carbon::parse($leave->start_date)->format('M d') }} –<br>
                            {{ \Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}
                        </td>
                        <td style="font-family:'DM Mono',monospace;font-size:13px;">{{ $leave->duration }}d</td>
                        <td>
                            <div class="d-flex gap-1">
                                <form method="POST" action="{{ route('leave.approve', $leave->id) }}">
                                    @csrf
                                    <button type="submit" style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;background:#f0fdf4;color:#10b981;border:1px solid #bbf7d0;cursor:pointer;transition:all .15s;" onmouseover="this.style.background='#dcfce7'" onmouseout="this.style.background='#f0fdf4'" title="Approve">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('leave.reject', $leave->id) }}">
                                    @csrf
                                    <button type="submit" style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;background:#fff5f5;color:#ef4444;border:1px solid #fecaca;cursor:pointer;transition:all .15s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fff5f5'" title="Reject">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="bi bi-check2-all d-block mb-1" style="font-size:22px;"></i>
                            No pending leave requests.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-12 col-xl-5 d-flex flex-column gap-3">

        {{-- Department headcount --}}
        <div class="data-card">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-diagram-3 me-2 text-primary"></i>Department Headcount</span>
            </div>
            <div class="p-3">
                @foreach($departmentList as $dept)
                @php $pct = $totalEmployees > 0 ? round(($dept->employees_count / $totalEmployees) * 100) : 0; @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:13px;font-weight:600;">{{ $dept->name }}</span>
                        <span style="font-size:12px;color:var(--text-muted);font-family:'DM Mono',monospace;">
                            {{ $dept->employees_count }} ({{ $pct }}%)
                        </span>
                    </div>
                    <div class="progress" style="height:6px;border-radius:10px;background:#e2e8f0;">
                        <div class="progress-bar" style="width:{{ $pct }}%;background:var(--brand-accent);border-radius:10px;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Quick actions --}}
        <div class="data-card">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-lightning me-2 text-warning"></i>Quick Actions</span>
            </div>
            <div class="p-3 d-grid gap-2">
                <a href="{{ route('employees.create') }}" style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;background:#6366f1;color:#fff;text-decoration:none;transition:background .15s;" onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#6366f1'">
                    <i class="bi bi-person-plus"></i> Add Employee
                </a>
                <a href="{{ route('attendance.report') }}" style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;background:#fff;color:#6366f1;text-decoration:none;border:1px solid #d4d4f5;transition:all .15s;" onmouseover="this.style.background='#f0f0fd'" onmouseout="this.style.background='#fff'">
                    <i class="bi bi-calendar-check"></i> View Attendance
                </a>
                <a href="{{ route('leave.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;background:#fff;color:#6366f1;text-decoration:none;border:1px solid #d4d4f5;transition:all .15s;" onmouseover="this.style.background='#f0f0fd'" onmouseout="this.style.background='#fff'">
                    <i class="bi bi-file-earmark-text"></i> All Leave Requests
                </a>
            </div>
        </div>
    </div>
</div>

@endsection