@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:var(--text-primary)">Team Attendance</h4>
        <p class="mb-0" style="font-size:13px;color:var(--text-muted)">Track your team's daily activity</p>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="bi bi-person-check"></i></div>
            <div class="stat-value">{{ $presentCount }}</div>
            <div class="stat-label">Present</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-amber"><i class="bi bi-clock-history"></i></div>
            <div class="stat-value">{{ $lateCount }}</div>
            <div class="stat-label">Late</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-red"><i class="bi bi-person-x"></i></div>
            <div class="stat-value">{{ $absentCount }}</div>
            <div class="stat-label">Absent</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-indigo"><i class="bi bi-calendar2-minus"></i></div>
            <div class="stat-value">{{ $onLeaveCount }}</div>
            <div class="stat-label">On Leave</div>
        </div>
    </div>
</div>

{{-- FILTERS --}}
<div class="data-card mb-4">
    <div class="p-3">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:4px;">Date</div>
                <input type="date" name="date" class="form-control form-control-sm"
                       value="{{ request('date') }}"
                       style="border-radius:9px;font-size:13px;width:100%;">
            </div>
            <div class="col-md-4">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:4px;">Employee</div>
                <input type="text" name="employee" class="form-control form-control-sm"
                       placeholder="Search name…"
                       value="{{ request('employee') }}"
                       style="border-radius:9px;font-size:13px;width:100%;">
            </div>
            <div class="col-md-3">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:4px;">Status</div>
                <select name="status" class="form-select form-select-sm" style="border-radius:9px;font-size:13px;width:100%;">
                    <option value="">All Status</option>
                    <option value="Present"  {{ request('status') == 'Present'  ? 'selected' : '' }}>Present</option>
                    <option value="Late"     {{ request('status') == 'Late'     ? 'selected' : '' }}>Late</option>
                    <option value="Absent"   {{ request('status') == 'Absent'   ? 'selected' : '' }}>Absent</option>
                    <option value="On Leave" {{ request('status') == 'On Leave' ? 'selected' : '' }}>On Leave</option>
                </select>
            </div>
                <div class="col-md-2" style="display:flex;gap:8px;">
                    <button type="submit"
                            style="flex:1;border-radius:9px;border:none;background:#6366f1;color:#fff;font-size:13px;font-weight:600;padding:6px 14px;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;display:inline-flex;align-items:center;justify-content:center;gap:4px;">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    @if(request('date') || request('employee') || request('status'))
                        <a href="{{ route('attendance.team') }}"
                        style="border-radius:9px;border:1px solid var(--border);background:#fff;color:var(--text-muted);font-size:13px;font-weight:600;padding:6px 12px;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
        </form>
    </div>
</div>
{{-- TABLE --}}
<div class="data-card">
    <div class="data-card-header">
        <span class="data-card-title">Team Records</span>
        <span style="font-size:12px;color:var(--text-muted);">{{ $attendances->count() }} records</span>
    </div>
    <div class="table-responsive">
        <table class="hris-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Department</th>
                    <th>Day / Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Status</th>
                    <th>Hours</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $att)
                <tr>
                    <td>
                        <div class="emp-info">
                            <div class="emp-avatar" style="font-size:11px;width:30px;height:30px;">
                                {{ strtoupper(substr($att->employee->user->name ?? 'N', 0, 1)) }}
                            </div>
                            <div>
                                <div class="emp-name">{{ $att->employee->user->name ?? 'N/A' }}</div>
                                <div class="emp-pos">ID #{{ $att->employee->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:13px;color:var(--text-muted);">{{ $att->employee->department->name ?? '—' }}</td>
                    <td>
                        <div style="font-weight:600;font-size:13px;">{{ \Carbon\Carbon::parse($att->attendance_date)->format('l') }}</div>
                        <div style="font-size:12px;color:var(--text-muted);">{{ \Carbon\Carbon::parse($att->attendance_date)->format('M d, Y') }}</div>
                    </td>
                    <td style="font-family:'DM Mono',monospace;font-size:13px;">
                        {{ $att->time_in ? \Carbon\Carbon::parse($att->time_in)->format('h:i A') : '—' }}
                    </td>
                    <td style="font-family:'DM Mono',monospace;font-size:13px;">
                        {{ $att->time_out ? \Carbon\Carbon::parse($att->time_out)->format('h:i A') : '—' }}
                    </td>
                    <td>
                        @if($att->status == 'Present')
                            <span class="badge-status badge-present">Present</span>
                        @elseif($att->status == 'Late')
                            <span class="badge-status badge-late">Late</span>
                        @elseif($att->status == 'Absent')
                            <span class="badge-status badge-absent">Absent</span>
                        @elseif($att->status == 'On Leave')
                            <span class="badge-status badge-on-leave">On Leave</span>
                        @else
                            <span class="badge-status">{{ $att->status }}</span>
                        @endif
                    </td>
                    <td style="font-weight:600;font-size:13px;">{{ $att->hours_worked ?? 0 }} hrs</td>
                    <td style="font-size:13px;color:var(--text-muted);">{{ $att->remarks ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:40px;color:var(--text-muted);">
                        <i class="bi bi-calendar-x" style="font-size:28px;display:block;margin-bottom:8px;opacity:.4;"></i>
                        No team attendance records found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection