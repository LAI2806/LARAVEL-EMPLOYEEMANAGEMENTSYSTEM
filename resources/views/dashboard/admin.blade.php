@extends('layouts.app')

@section('content')

<h4 class="fw-bold mb-1">Admin Dashboard</h4>
<p class="text-muted mb-4" style="font-size:13px;">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon icon-indigo"><i class="bi bi-people-fill"></i></div>
            <div class="stat-value">{{ $totalEmployees }}</div>
            <div class="stat-label">Total Employees</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="bi bi-diagram-3-fill"></i></div>
            <div class="stat-value">{{ $totalDepartments }}</div>
            <div class="stat-label">Departments</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon icon-purple"><i class="bi bi-person-plus-fill"></i></div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-label">System Users</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="bi bi-check-circle-fill"></i></div>
            <div class="stat-value">{{ $presentToday }}</div>
            <div class="stat-label">Present Today</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon icon-red"><i class="bi bi-x-circle-fill"></i></div>
            <div class="stat-value">{{ $absentToday }}</div>
            <div class="stat-label">Absent Today</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon icon-amber"><i class="bi bi-hourglass-split"></i></div>
            <div class="stat-value">{{ $pendingLeaves }}</div>
            <div class="stat-label">Pending Leaves</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">

    <div class="col-12 col-xl-7">
        <div class="data-card h-100">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-diagram-3 me-2 text-primary"></i>Department Breakdown</span>
                <a href="{{ route('leave.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:9px;font-size:12px;font-weight:600;background:#fff;color:#6366f1;text-decoration:none;border:1px solid #d4d4f5;transition:all .15s;" onmouseover="this.style.background='#f0f0fd'" onmouseout="this.style.background='#fff'">
                    View All
                </a>
            </div>
            <table class="hris-table">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Manager</th>
                        <th>Employees</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departmentSummary as $dept)
                    <tr>
                        <td>
                            <div style="font-weight:600;">{{ $dept->name }}</div>
                            @if($dept->description)
                                <div style="font-size:12px;color:var(--text-muted);">{{ Str::limit($dept->description, 40) }}</div>
                            @endif
                        </td>
                        <td style="color:var(--text-muted);font-size:13px;">{{ $dept->manager?->name ?? '—' }}</td>
                        <td><span class="badge bg-light text-dark fw-semibold">{{ $dept->employees_count }}</span></td>
                        <td>
                            <span class="badge-status {{ ($dept->status ?? 'active') === 'active' ? 'badge-present' : 'badge-absent' }}">
                                {{ ucfirst($dept->status ?? 'active') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">No departments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-12 col-xl-5 d-flex flex-column gap-3">

        <div class="data-card">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-people me-2 text-primary"></i>Users by Role</span>
            </div>
            <div class="p-3">
                @foreach(['admin'=>['icon-purple','bi-person-gear'],'hr'=>['icon-blue','bi-person-badge'],'manager'=>['icon-indigo','bi-person-workspace'],'employee'=>['icon-green','bi-person']] as $role=>$meta)
                <div class="d-flex align-items-center justify-content-between p-2 rounded mb-1" style="background:#f8fafc;">
                    <div class="d-flex align-items-center gap-2">
                        <div class="stat-icon {{ $meta[0] }}" style="width:32px;height:32px;font-size:14px;margin:0;flex-shrink:0;">
                            <i class="bi {{ $meta[1] }}"></i>
                        </div>
                        <span style="font-size:13px;font-weight:600;">{{ ucfirst($role) }}</span>
                    </div>
                    <span class="badge bg-light text-dark fw-bold" style="font-family:'DM Mono',monospace;">{{ $usersByRole[$role] ?? 0 }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="data-card">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-lightning me-2 text-warning"></i>Quick Actions</span>
            </div>
                <div class="p-3 d-grid gap-2">
                    <a href="{{ route('employees.create') }}" style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;background:#6366f1;color:#fff;text-decoration:none;transition:background .15s;" onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#6366f1'">
                        <i class="bi bi-person-plus"></i> Add New Employee
                    </a>
                    <a href="{{ route('departments.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;background:#fff;color:#6366f1;text-decoration:none;border:1px solid #d4d4f5;transition:all .15s;" onmouseover="this.style.background='#f0f0fd'" onmouseout="this.style.background='#fff'">
                        <i class="bi bi-diagram-3"></i> Manage Departments
                    </a>
                    <a href="{{ route('attendance.report') }}" style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;background:#fff;color:#6366f1;text-decoration:none;border:1px solid #d4d4f5;transition:all .15s;" onmouseover="this.style.background='#f0f0fd'" onmouseout="this.style.background='#fff'">
                        <i class="bi bi-calendar-check"></i> Attendance Report
                    </a>
                    <a href="{{ route('leave.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;background:#fff;color:#6366f1;text-decoration:none;border:1px solid #d4d4f5;transition:all .15s;" onmouseover="this.style.background='#f0f0fd'" onmouseout="this.style.background='#fff'">
                        <i class="bi bi-file-earmark-text"></i> Leave Requests
                    </a>
                </div>
        </div>
    </div>
</div>

<div class="data-card">
    <div class="data-card-header">
        <span class="data-card-title"><i class="bi bi-clock-history me-2 text-primary"></i>Recent Leave Requests</span>
        <a href="{{ route('leave.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:9px;font-size:12px;font-weight:600;background:#fff;color:#6366f1;text-decoration:none;border:1px solid #d4d4f5;transition:all .15s;" onmouseover="this.style.background='#f0f0fd'" onmouseout="this.style.background='#fff'">View All</a>
    </div>
    <table class="hris-table">
        <thead>
            <tr><th>Employee</th><th>Leave Type</th><th>Period</th><th>Duration</th><th>Status</th></tr>
        </thead>
        <tbody>
            @forelse($recentActivities as $leave)
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
                <td style="font-size:13px;color:var(--text-muted);">
                    {{ \Carbon\Carbon::parse($leave->start_date)->format('M d') }} – {{ \Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}
                </td>
                <td style="font-size:13px;font-family:'DM Mono',monospace;">{{ $leave->duration }}d</td>
                <td><span class="badge-status badge-{{ strtolower($leave->status) }}">{{ ucfirst($leave->status) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-4 text-muted">No recent leave requests.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection