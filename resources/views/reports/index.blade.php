@extends('layouts.app')

@push('styles')
<style>
    .report-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 28px;
    }
    .report-title {
        font-size: 22px;
        font-weight: 800;
        color: var(--text-primary);
        margin: 0;
        line-height: 1.2;
    }
    .report-subtitle {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 4px;
    }

    .filter-bar {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 12px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: var(--shadow);
    }
    .filter-bar label {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: .6px;
        margin: 0;
        white-space: nowrap;
    }
    .filter-bar select {
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 6px 10px;
        font-size: 13px;
        font-family: inherit;
        color: var(--text-primary);
        background: #f8fafc;
        cursor: pointer;
        outline: none;
    }
    .filter-bar select:focus { border-color: var(--brand-accent); }
    .filter-btn {
        background: var(--brand-accent);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 7px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: opacity .15s;
    }
    .filter-btn:hover { opacity: .88; }

    .section-heading {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .7px;
        color: var(--text-muted);
        margin: 28px 0 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-heading::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .chart-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px;
        box-shadow: var(--shadow);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .chart-card-title {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .chart-card-title i {
        color: var(--brand-accent);
        font-size: 15px;
    }
    .chart-canvas-wrap {
        position: relative;
        flex: 1;
        min-height: 0;
    }
    .donut-wrap {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 200px;
        height: 200px;
        margin: 0 auto;
    }
    .donut-wrap canvas {
        width: 200px !important;
        height: 200px !important;
    }
    .donut-center {
        position: absolute;
        text-align: center;
        pointer-events: none;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .donut-center .dc-val {
        font-size: 26px;
        font-weight: 800;
        font-family: 'DM Mono', monospace;
        color: var(--text-primary);
        line-height: 1;
    }
    .donut-center .dc-lbl {
        font-size: 11px;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-top: 3px;
    }

    .chart-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 14px;
        margin-top: 14px;
        justify-content: center;
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 600;
    }
    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .dept-bar-wrap { margin-top: 4px; }
    .dept-bar-track {
        background: #eef0f8;
        border-radius: 6px;
        height: 7px;
        overflow: hidden;
    }
    .dept-bar-fill {
        height: 100%;
        border-radius: 6px;
        background: linear-gradient(90deg, #6366f1, #818cf8);
        transition: width .5s ease;
    }

    .empty-state {
        padding: 40px 20px;
        text-align: center;
        color: var(--text-muted);
    }
    .empty-state i { font-size: 36px; opacity: .35; display: block; margin-bottom: 10px; }
    .empty-state p { font-size: 13.5px; margin: 0; }

    .role-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .chip-admin    { background: rgba(99,102,241,.12); color: #6366f1; }
    .chip-hr       { background: rgba(16,185,129,.12); color: #10b981; }
    .chip-manager  { background: rgba(59,130,246,.12); color: #3b82f6; }
    .chip-employee { background: rgba(245,158,11,.12); color: #d97706; }

    .report-tabs {
        display: flex;
        gap: 4px;
        background: #f1f3fb;
        padding: 4px;
        border-radius: 12px;
        margin-bottom: 22px;
        flex-wrap: wrap;
    }
    .rtab {
        padding: 8px 16px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        border: none;
        background: transparent;
        font-family: inherit;
        transition: all .15s;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .rtab:hover { color: var(--brand-accent); background: #e8e9f8; }
    .rtab.active { background: #fff; color: var(--brand-accent); box-shadow: 0 1px 6px rgba(0,0,0,.08); }

    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    .print-btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 7px 14px; border-radius: 8px;
        font-size: 12.5px; font-weight: 600;
        border: 1px solid var(--border);
        background: var(--card-bg);
        color: var(--text-muted);
        cursor: pointer;
        font-family: inherit;
        transition: all .15s;
        text-decoration: none;
    }
    .print-btn:hover { border-color: var(--brand-accent); color: var(--brand-accent); background: #f5f5fd; }

    @media print {
        .sidebar, .filter-bar, .report-tabs, .print-btn { display: none !important; }
        .tab-panel { display: block !important; }
        .main-content { padding: 0 !important; }
    }
</style>
@endpush

@section('content')

<div class="report-header">
    <div>
        <h1 class="report-title">
            <i class="bi bi-bar-chart-line me-2" style="color: var(--brand-accent);"></i>Reports
        </h1>
        <div class="report-subtitle d-flex align-items-center gap-2 mt-1">
            <span>
                @php
                    $monthName = \Carbon\Carbon::createFromDate($year, $month, 1)->format('F');
                @endphp
                Showing data for <strong>{{ $monthName }} {{ $year }}</strong>
            </span>
            <span class="role-chip chip-{{ $role }}">
                <i class="bi bi-person-badge"></i>{{ ucfirst($role) }} view
            </span>
        </div>
    </div>

    <div class="d-flex align-items-center gap-2 flex-wrap">
        <form method="GET" action="{{ route('reports.index') }}" class="filter-bar">
            <label><i class="bi bi-calendar3 me-1"></i>Period</label>
            <select name="month">
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                        {{ \DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                @endforeach
            </select>
            <select name="year">
                @foreach(range(\Carbon\Carbon::now()->year - 2, \Carbon\Carbon::now()->year) as $y)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
            <button type="submit" class="filter-btn">
                <i class="bi bi-funnel me-1"></i>Filter
            </button>
        </form>

        <button class="print-btn" onclick="window.print()">
            <i class="bi bi-printer"></i> Print
        </button>
    </div>
</div>

@if(in_array($role, ['admin', 'hr']))

<div class="report-tabs">
    <button class="rtab active" data-tab="overview"><i class="bi bi-grid-1x2"></i>Overview</button>
    <button class="rtab" data-tab="employees"><i class="bi bi-people"></i>Employees</button>
    <button class="rtab" data-tab="attendance"><i class="bi bi-calendar-check"></i>Attendance</button>
    <button class="rtab" data-tab="leaves"><i class="bi bi-file-earmark-text"></i>Leave Requests</button>
    <button class="rtab" data-tab="departments"><i class="bi bi-diagram-3"></i>Departments</button>
</div>

<div class="tab-panel active" id="tab-overview">

    <div class="section-heading">Overview</div>

    <div class="row g-3 mb-3">

        <div class="col-12 col-md-4">
            <div class="chart-card">
                <div class="chart-card-title"><i class="bi bi-people-fill"></i>Employee Status</div>
                <div class="donut-wrap">
                    <canvas id="chart-emp-status"></canvas>
                    <div class="donut-center">
                        <div class="dc-val">{{ $totalEmployees }}</div>
                        <div class="dc-lbl">Total</div>
                    </div>
                </div>
                <div class="chart-legend">
                    <span class="legend-item"><span class="legend-dot" style="background:#10b981;"></span>Active ({{ $activeEmployees }})</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#e5e7eb;border:1px solid #d1d5db;"></span>Inactive ({{ $totalEmployees - $activeEmployees }})</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#6366f1;"></span>New hires ({{ $newHiresThisMonth }})</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="chart-card">
                <div class="chart-card-title"><i class="bi bi-calendar-check"></i>Attendance This Month</div>
                <div class="donut-wrap">
                    <canvas id="chart-attendance-overview"></canvas>
                    <div class="donut-center">
                        <div class="dc-val">{{ $presentThisMonth + $lateThisMonth + $absentThisMonth }}</div>
                        <div class="dc-lbl">Records</div>
                    </div>
                </div>
                <div class="chart-legend">
                    <span class="legend-item"><span class="legend-dot" style="background:#10b981;"></span>Present ({{ $presentThisMonth }})</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#f59e0b;"></span>Late ({{ $lateThisMonth }})</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#ef4444;"></span>Absent ({{ $absentThisMonth }})</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="chart-card">
                <div class="chart-card-title"><i class="bi bi-file-earmark-text"></i>Leave Requests This Month</div>
                <div class="donut-wrap">
                    <canvas id="chart-leave-overview"></canvas>
                    <div class="donut-center">
                        <div class="dc-val">{{ $totalLeaves }}</div>
                        <div class="dc-lbl">Total</div>
                    </div>
                </div>
                <div class="chart-legend">
                    <span class="legend-item"><span class="legend-dot" style="background:#10b981;"></span>Approved ({{ $approvedLeaves }})</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#f59e0b;"></span>Pending ({{ $pendingLeaves }})</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#ef4444;"></span>Rejected ({{ $rejectedLeaves }})</span>
                </div>
            </div>
        </div>

    </div>
    <div class="row g-3">
        <div class="col-12">
            <div class="chart-card">
                <div class="chart-card-title">
                    <i class="bi bi-diagram-3"></i>Headcount by Department
                </div>
                <div style="position:relative; width:100%; height:{{ max(count($departments ?? []) * 55, 200) }}px; overflow:hidden;">
                    <canvas id="chart-dept-bar"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="tab-panel" id="tab-employees">
    <div class="data-card">
        <div class="data-card-header">
            <span class="data-card-title"><i class="bi bi-people me-2 text-indigo"></i>All Employees</span>
            <span class="badge bg-light text-secondary fw-semibold" style="font-size:12px;">{{ $employeeList->count() }} records</span>
        </div>
        <div class="table-responsive">
            <table class="hris-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Hire Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employeeList as $i => $emp)
                    <tr>
                        <td style="color:var(--text-muted);font-size:12px;">{{ $i + 1 }}</td>
                        <td>
                            <div class="emp-info">
                                <div class="emp-avatar">{{ strtoupper(substr($emp->first_name,0,1)) }}{{ strtoupper(substr($emp->last_name,0,1)) }}</div>
                                <div>
                                    <div class="emp-name">{{ $emp->full_name }}</div>
                                    <div class="emp-pos">{{ $emp->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $emp->position }}</td>
                        <td>{{ $emp->department?->name ?? '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($emp->hire_date)->format('M d, Y') }}</td>
                        <td>
                            <span class="badge-status {{ $emp->employment_status === 'active' ? 'badge-present' : 'badge-absent' }}">
                                {{ ucfirst($emp->employment_status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="bi bi-people"></i><p>No employees found.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="tab-panel" id="tab-attendance">
    <div class="data-card">
        <div class="data-card-header">
            <span class="data-card-title"><i class="bi bi-calendar-check me-2"></i>Attendance Records — {{ \DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</span>
            <span class="badge bg-light text-secondary fw-semibold" style="font-size:12px;">{{ $attendanceList->count() }} records</span>
        </div>
        <div class="table-responsive">
            <table class="hris-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Hours</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendanceList as $att)
                    <tr>
                        <td>
                            <div class="emp-info">
                                <div class="emp-avatar">{{ strtoupper(substr($att->employee?->first_name,0,1)) }}{{ strtoupper(substr($att->employee?->last_name,0,1)) }}</div>
                                <div class="emp-name">{{ $att->employee?->full_name ?? '—' }}</div>
                            </div>
                        </td>
                        <td>{{ $att->employee?->department?->name ?? '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($att->attendance_date)->format('M d, Y') }}</td>
                        <td>{{ $att->time_in ? \Carbon\Carbon::parse($att->time_in)->format('h:i A') : '—' }}</td>
                        <td>{{ $att->time_out ? \Carbon\Carbon::parse($att->time_out)->format('h:i A') : '—' }}</td>
                        <td>
                            @if($att->time_in && $att->time_out)
                                <span style="font-family:'DM Mono',monospace;font-size:13px;">{{ $att->hours_worked }}h</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @php $s = strtolower($att->status); @endphp
                            <span class="badge-status badge-{{ $s === 'on leave' ? 'on-leave' : $s }}">{{ $att->status }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7"><div class="empty-state"><i class="bi bi-calendar-x"></i><p>No attendance records for this period.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="tab-panel" id="tab-leaves">
    <div class="data-card">
        <div class="data-card-header">
            <span class="data-card-title"><i class="bi bi-file-earmark-text me-2"></i>Leave Requests — {{ \DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</span>
            <span class="badge bg-light text-secondary fw-semibold" style="font-size:12px;">{{ $leaveList->count() }} requests</span>
        </div>
        <div class="table-responsive">
            <table class="hris-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Leave Type</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Days</th>
                        <th>Reason</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaveList as $leave)
                    <tr>
                        <td>
                            <div class="emp-info">
                                <div class="emp-avatar">{{ strtoupper(substr($leave->employee?->first_name,0,1)) }}{{ strtoupper(substr($leave->employee?->last_name,0,1)) }}</div>
                                <div class="emp-name">{{ $leave->employee?->full_name ?? '—' }}</div>
                            </div>
                        </td>
                        <td>{{ $leave->leave_type }}</td>
                        <td>{{ $leave->start_date->format('M d, Y') }}</td>
                        <td>{{ $leave->end_date->format('M d, Y') }}</td>
                        <td><span style="font-family:'DM Mono',monospace;">{{ $leave->duration }}d</span></td>
                        <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $leave->reason }}">{{ $leave->reason }}</td>
                        <td>
                            <span class="badge-status badge-{{ $leave->status }}">{{ ucfirst($leave->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7"><div class="empty-state"><i class="bi bi-file-earmark-x"></i><p>No leave requests for this period.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="tab-panel" id="tab-departments">

    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-8">
            <div class="chart-card" style="overflow:hidden;">
                <div class="chart-card-title"><i class="bi bi-diagram-3"></i>Headcount by Department</div>
                <canvas id="chart-dept-bar" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="data-card">
        <div class="data-card-header">
            <span class="data-card-title"><i class="bi bi-diagram-3 me-2"></i>Department Employee Breakdown</span>
            <span class="badge bg-light text-secondary fw-semibold" style="font-size:12px;">{{ $departments->count() }} departments</span>
        </div>
        <div class="table-responsive">
            <table class="hris-table">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th style="width:200px;">Headcount</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    @php $maxCount = $departments->max('employees_count') ?: 1; @endphp
                    @forelse($departments as $dept)
                    <tr>
                        <td><strong>{{ $dept->name }}</strong></td>
                        <td style="color:var(--text-muted);font-size:13px;">{{ $dept->description ?? '—' }}</td>
                        <td>
                            <span class="badge-status {{ $dept->status === 'active' ? 'badge-present' : 'badge-absent' }}">
                                {{ ucfirst($dept->status ?? 'active') }}
                            </span>
                        </td>
                        <td>
                            <div class="dept-bar-wrap">
                                <div class="dept-bar-track">
                                    <div class="dept-bar-fill" style="width: {{ ($dept->employees_count / $maxCount) * 100 }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-family:'DM Mono',monospace;font-weight:700;color:var(--brand-accent);">{{ $dept->employees_count }}</span>
                            <span style="color:var(--text-muted);font-size:12px;"> emp.</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5"><div class="empty-state"><i class="bi bi-diagram-3"></i><p>No departments found.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endif 

@if($role === 'manager')

<div class="report-tabs">
    <button class="rtab active" data-tab="mgr-overview"><i class="bi bi-grid-1x2"></i>Overview</button>
    <button class="rtab" data-tab="mgr-employees"><i class="bi bi-people"></i>My Team</button>
    <button class="rtab" data-tab="mgr-attendance"><i class="bi bi-calendar-check"></i>Attendance</button>
    <button class="rtab" data-tab="mgr-leaves"><i class="bi bi-file-earmark-text"></i>Leave Requests</button>
</div>

@php $deptName = $department?->name ?? 'Your Department'; @endphp

<div class="tab-panel active" id="tab-mgr-overview">

    <div class="section-heading">{{ $deptName }} — Overview</div>
    <div class="row g-3">

        <div class="col-12 col-md-6">
            <div class="chart-card">
                <div class="chart-card-title"><i class="bi bi-calendar-check"></i>Attendance This Month</div>
                <div class="donut-wrap">
                    <canvas id="chart-mgr-attendance"></canvas>
                    <div class="donut-center">
                        <div class="dc-val">{{ $presentThisMonth + $lateThisMonth + $absentThisMonth }}</div>
                        <div class="dc-lbl">Records</div>
                    </div>
                </div>
                <div class="chart-legend">
                    <span class="legend-item"><span class="legend-dot" style="background:#10b981;"></span>Present ({{ $presentThisMonth }})</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#f59e0b;"></span>Late ({{ $lateThisMonth }})</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#ef4444;"></span>Absent ({{ $absentThisMonth }})</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="chart-card">
                <div class="chart-card-title"><i class="bi bi-file-earmark-text"></i>Leave Requests This Month</div>
                <div class="donut-wrap">
                    <canvas id="chart-mgr-leave"></canvas>
                    <div class="donut-center">
                        <div class="dc-val">{{ $totalLeaves }}</div>
                        <div class="dc-lbl">Total</div>
                    </div>
                </div>
                <div class="chart-legend">
                    <span class="legend-item"><span class="legend-dot" style="background:#10b981;"></span>Approved ({{ $approvedLeaves }})</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#f59e0b;"></span>Pending ({{ $pendingLeaves }})</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#ef4444;"></span>Rejected ({{ $rejectedLeaves }})</span>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="tab-panel" id="tab-mgr-employees">
    <div class="data-card">
        <div class="data-card-header">
            <span class="data-card-title"><i class="bi bi-people me-2"></i>{{ $deptName }} — Employees</span>
            <span class="badge bg-light text-secondary fw-semibold" style="font-size:12px;">{{ $employeeList->count() }} members</span>
        </div>
        <div class="table-responsive">
            <table class="hris-table">
                <thead><tr><th>#</th><th>Employee</th><th>Position</th><th>Hire Date</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($employeeList as $i => $emp)
                    <tr>
                        <td style="color:var(--text-muted);font-size:12px;">{{ $i + 1 }}</td>
                        <td>
                            <div class="emp-info">
                                <div class="emp-avatar">{{ strtoupper(substr($emp->first_name,0,1)) }}{{ strtoupper(substr($emp->last_name,0,1)) }}</div>
                                <div>
                                    <div class="emp-name">{{ $emp->full_name }}</div>
                                    <div class="emp-pos">{{ $emp->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $emp->position }}</td>
                        <td>{{ \Carbon\Carbon::parse($emp->hire_date)->format('M d, Y') }}</td>
                        <td><span class="badge-status {{ $emp->employment_status === 'active' ? 'badge-present' : 'badge-absent' }}">{{ ucfirst($emp->employment_status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="5"><div class="empty-state"><i class="bi bi-people"></i><p>No employees in your department.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="tab-panel" id="tab-mgr-attendance">
    <div class="data-card">
        <div class="data-card-header">
            <span class="data-card-title"><i class="bi bi-calendar-check me-2"></i>Team Attendance — {{ \DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</span>
            <span class="badge bg-light text-secondary fw-semibold" style="font-size:12px;">{{ $attendanceList->count() }} records</span>
        </div>
        <div class="table-responsive">
            <table class="hris-table">
                <thead><tr><th>Employee</th><th>Date</th><th>Time In</th><th>Time Out</th><th>Hours</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($attendanceList as $att)
                    <tr>
                        <td>
                            <div class="emp-info">
                                <div class="emp-avatar">{{ strtoupper(substr($att->employee?->first_name,0,1)) }}{{ strtoupper(substr($att->employee?->last_name,0,1)) }}</div>
                                <div class="emp-name">{{ $att->employee?->full_name ?? '—' }}</div>
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($att->attendance_date)->format('M d, Y') }}</td>
                        <td>{{ $att->time_in ? \Carbon\Carbon::parse($att->time_in)->format('h:i A') : '—' }}</td>
                        <td>{{ $att->time_out ? \Carbon\Carbon::parse($att->time_out)->format('h:i A') : '—' }}</td>
                        <td><span style="font-family:'DM Mono',monospace;font-size:13px;">{{ $att->time_in && $att->time_out ? $att->hours_worked.'h' : '—' }}</span></td>
                        <td>@php $s = strtolower($att->status); @endphp
                            <span class="badge-status badge-{{ $s === 'on leave' ? 'on-leave' : $s }}">{{ $att->status }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="bi bi-calendar-x"></i><p>No attendance records for this period.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="tab-panel" id="tab-mgr-leaves">
    <div class="data-card">
        <div class="data-card-header">
            <span class="data-card-title"><i class="bi bi-file-earmark-text me-2"></i>Team Leave Requests — {{ \DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</span>
            <span class="badge bg-light text-secondary fw-semibold" style="font-size:12px;">{{ $leaveList->count() }} requests</span>
        </div>
        <div class="table-responsive">
            <table class="hris-table">
                <thead><tr><th>Employee</th><th>Type</th><th>Start</th><th>End</th><th>Days</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($leaveList as $leave)
                    <tr>
                        <td>
                            <div class="emp-info">
                                <div class="emp-avatar">{{ strtoupper(substr($leave->employee?->first_name,0,1)) }}{{ strtoupper(substr($leave->employee?->last_name,0,1)) }}</div>
                                <div class="emp-name">{{ $leave->employee?->full_name ?? '—' }}</div>
                            </div>
                        </td>
                        <td>{{ $leave->leave_type }}</td>
                        <td>{{ $leave->start_date->format('M d, Y') }}</td>
                        <td>{{ $leave->end_date->format('M d, Y') }}</td>
                        <td><span style="font-family:'DM Mono',monospace;">{{ $leave->duration }}d</span></td>
                        <td><span class="badge-status badge-{{ $leave->status }}">{{ ucfirst($leave->status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="bi bi-file-earmark-x"></i><p>No leave requests for this period.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endif {{-- end manager --}}

@if($role === 'employee')

<div class="report-tabs">
    <button class="rtab active" data-tab="emp-overview"><i class="bi bi-grid-1x2"></i>Overview</button>
    <button class="rtab" data-tab="emp-attendance"><i class="bi bi-calendar-check"></i>My Attendance</button>
    <button class="rtab" data-tab="emp-leaves"><i class="bi bi-file-earmark-text"></i>My Leaves</button>
</div>

<div class="tab-panel active" id="tab-emp-overview">

    <div class="section-heading">My Overview</div>
    <div class="row g-3">

        <div class="col-12 col-md-6">
            <div class="chart-card">
                <div class="chart-card-title"><i class="bi bi-calendar-check"></i>My Attendance This Month</div>
                <div class="donut-wrap">
                    <canvas id="chart-emp-attendance"></canvas>
                    <div class="donut-center">
                        <div class="dc-val">{{ $presentCount + $lateCount + $absentCount }}</div>
                        <div class="dc-lbl">Records</div>
                    </div>
                </div>
                <div class="chart-legend">
                    <span class="legend-item"><span class="legend-dot" style="background:#10b981;"></span>Present ({{ $presentCount }})</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#f59e0b;"></span>Late ({{ $lateCount }})</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#ef4444;"></span>Absent ({{ $absentCount }})</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="chart-card">
                <div class="chart-card-title"><i class="bi bi-file-earmark-text"></i>My Leave Requests</div>
                <div class="donut-wrap">
                    <canvas id="chart-emp-leave"></canvas>
                    <div class="donut-center">
                        <div class="dc-val">{{ $totalLeaves }}</div>
                        <div class="dc-lbl">Total</div>
                    </div>
                </div>
                <div class="chart-legend">
                    <span class="legend-item"><span class="legend-dot" style="background:#10b981;"></span>Approved ({{ $approvedLeaves }})</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#f59e0b;"></span>Pending ({{ $pendingLeaves }})</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#ef4444;"></span>Rejected ({{ $rejectedLeaves }})</span>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="tab-panel" id="tab-emp-attendance">
    <div class="data-card">
        <div class="data-card-header">
            <span class="data-card-title"><i class="bi bi-calendar-check me-2"></i>My Attendance — {{ \DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</span>
            <span class="badge bg-light text-secondary fw-semibold" style="font-size:12px;">{{ $myAttendance->count() }} records</span>
        </div>
        <div class="table-responsive">
            <table class="hris-table">
                <thead><tr><th>Date</th><th>Time In</th><th>Time Out</th><th>Hours Worked</th><th>Status</th><th>Remarks</th></tr></thead>
                <tbody>
                    @forelse($myAttendance as $att)
                    <tr>
                        <td>{{ date('M d, Y', strtotime($att->attendance_date)) }}</td>
                        <td>{{ $att->time_in ? date('h:i A', strtotime($att->time_in)) : '—' }}</td>
                        <td>{{ $att->time_out ? date('h:i A', strtotime($att->time_out)) : '—' }}</td>
                        <td><span style="font-family:'DM Mono',monospace;font-size:13px;">{{ $att->time_in && $att->time_out ? $att->hours_worked.'h' : '—' }}</span></td>
                        <td>@php $s = strtolower($att->status); @endphp
                            <span class="badge-status badge-{{ $s === 'on leave' ? 'on-leave' : $s }}">{{ $att->status }}</span>
                        </td>
                        <td style="color:var(--text-muted);font-size:13px;">{{ $att->remarks ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="bi bi-calendar-x"></i><p>No attendance records for this period.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="tab-panel" id="tab-emp-leaves">
    <div class="data-card">
        <div class="data-card-header">
            <span class="data-card-title"><i class="bi bi-file-earmark-text me-2"></i>My Leave Requests — {{ \DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</span>
            <span class="badge bg-light text-secondary fw-semibold" style="font-size:12px;">{{ $myLeaves->count() }} requests</span>
        </div>
        <div class="table-responsive">
            <table class="hris-table">
                <thead><tr><th>Type</th><th>Start</th><th>End</th><th>Days</th><th>Reason</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($myLeaves as $leave)
                    <tr>
                        <td>{{ $leave->leave_type }}</td>
                        <td>{{ date('M d, Y', strtotime($leave->start_date)) }}</td>
                        <td>{{ date('M d, Y', strtotime($leave->end_date)) }}</td>
                        <td><span style="font-family:'DM Mono',monospace;">{{ $leave->duration }}d</span></td>
                        <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $leave->reason }}">{{ $leave->reason }}</td>
                        <td><span class="badge-status badge-{{ $leave->status }}">{{ ucfirst($leave->status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="bi bi-file-earmark-x"></i><p>No leave requests for this period.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endif {{-- end employee --}}

@endsection

<script id="report-data" type="application/json">
{
    "role":              "{{ $role }}",
    "activeEmployees":   {{ $activeEmployees ?? 0 }},
    "inactiveEmployees": {{ ($totalEmployees ?? 0) - ($activeEmployees ?? 0) }},
    "newHires":          {{ $newHiresThisMonth ?? 0 }},
    "presentMonth":      {{ $presentThisMonth ?? 0 }},
    "lateMonth":         {{ $lateThisMonth ?? 0 }},
    "absentMonth":       {{ $absentThisMonth ?? 0 }},
    "totalLeaves":       {{ $totalLeaves ?? 0 }},
    "approvedLeaves":    {{ $approvedLeaves ?? 0 }},
    "pendingLeaves":     {{ $pendingLeaves ?? 0 }},
    "rejectedLeaves":    {{ $rejectedLeaves ?? 0 }},
    "presentCount":      {{ $presentCount ?? 0 }},
    "lateCount":         {{ $lateCount ?? 0 }},
    "absentCount":       {{ $absentCount ?? 0 }},
    "deptLabels":        @json(isset($departments) ? $departments->pluck('name') : []),
    "deptCounts":        @json(isset($departments) ? $departments->pluck('employees_count') : [])
}
</script>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    const D = JSON.parse(document.getElementById('report-data').textContent);

    Chart.defaults.font.family = "'DM Sans', 'Inter', system-ui, sans-serif";

    function makeDonut(id, labels, data, colors) {
        const el = document.getElementById(id);
        if (!el) return;
        new Chart(el, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors,
                    borderWidth: 3,
                    borderColor: '#fff',
                    hoverOffset: 6,
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (ctx) { return ' ' + ctx.label + ': ' + ctx.parsed; }
                        }
                    }
                },
                animation: { animateRotate: true, duration: 700 }
            }
        });
    }

    function makeDeptBar(id, labels, counts) {
        const el = document.getElementById(id);
        if (!el) return;
        const palette = [
            '#6366f1','#818cf8','#10b981','#34d399','#f59e0b',
            '#fbbf24','#ef4444','#f87171','#3b82f6','#60a5fa'
        ];
        new Chart(el, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Employees',
                    data: counts,
                    backgroundColor: counts.map(function (_, i) { return palette[i % palette.length]; }),
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (ctx) {
                                return ' ' + ctx.parsed.x + ' employee' + (ctx.parsed.x !== 1 ? 's' : '');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { precision: 0, color: '#94a3b8', font: { size: 12 } },
                        grid:  { color: '#f1f3fb' }
                    },
                    y: {
                        ticks: { color: '#475569', font: { size: 12, weight: '600' } },
                        grid:  { display: false }
                    }
                },
                animation: { duration: 700 }
            }
        });
    }

    if (D.role === 'admin' || D.role === 'hr') {
        makeDonut(
            'chart-emp-status',
            ['Active', 'Inactive', 'New hires'],
            [D.activeEmployees, D.inactiveEmployees, D.newHires],
            ['#10b981', '#e5e7eb', '#6366f1']
        );
        makeDonut(
            'chart-attendance-overview',
            ['Present', 'Late', 'Absent'],
            [D.presentMonth, D.lateMonth, D.absentMonth],
            ['#10b981', '#f59e0b', '#ef4444']
        );
        makeDonut(
            'chart-leave-overview',
            ['Approved', 'Pending', 'Rejected'],
            [D.approvedLeaves, D.pendingLeaves, D.rejectedLeaves],
            ['#10b981', '#f59e0b', '#ef4444']
        );
        makeDeptBar('chart-dept-bar', D.deptLabels, D.deptCounts);
    }

    if (D.role === 'manager') {
        makeDonut(
            'chart-mgr-attendance',
            ['Present', 'Late', 'Absent'],
            [D.presentMonth, D.lateMonth, D.absentMonth],
            ['#10b981', '#f59e0b', '#ef4444']
        );
        makeDonut(
            'chart-mgr-leave',
            ['Approved', 'Pending', 'Rejected'],
            [D.approvedLeaves, D.pendingLeaves, D.rejectedLeaves],
            ['#10b981', '#f59e0b', '#ef4444']
        );
    }

    if (D.role === 'employee') {
        makeDonut(
            'chart-emp-attendance',
            ['Present', 'Late', 'Absent'],
            [D.presentCount, D.lateCount, D.absentCount],
            ['#10b981', '#f59e0b', '#ef4444']
        );
        makeDonut(
            'chart-emp-leave',
            ['Approved', 'Pending', 'Rejected'],
            [D.approvedLeaves, D.pendingLeaves, D.rejectedLeaves],
            ['#10b981', '#f59e0b', '#ef4444']
        );
    }

    document.querySelectorAll('.rtab').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target   = btn.dataset.tab;
            var tabGroup = btn.closest('.report-tabs');

            tabGroup.querySelectorAll('.rtab').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');

            var siblingIds = Array.from(tabGroup.querySelectorAll('.rtab')).map(function (b) { return 'tab-' + b.dataset.tab; });
            document.querySelectorAll('.tab-panel').forEach(function (p) {
                if (siblingIds.includes(p.id)) {
                    p.classList.toggle('active', p.id === 'tab-' + target);
                }
            });
        });
    });

})();
</script>
@endpush
