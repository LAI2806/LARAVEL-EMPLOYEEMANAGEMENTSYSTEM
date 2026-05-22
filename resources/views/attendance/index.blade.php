@extends('layouts.app')

@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <div>
        <h4 style="font-size:20px;font-weight:700;color:var(--text-primary);margin:0;">My Attendance</h4>
        <p style="font-size:13px;color:var(--text-muted);margin:4px 0 0;">{{ \Carbon\Carbon::now()->format('l, F d, Y') }}</p>
    </div>
</div>

@if(session('success'))
    <div style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.25);color:#059669;border-radius:10px;padding:12px 16px;font-size:13.5px;margin-bottom:16px;">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);color:#dc2626;border-radius:10px;padding:12px 16px;font-size:13.5px;margin-bottom:16px;">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
    </div>
@endif

<div class="data-card" style="margin-bottom:16px;">
    <div style="padding:20px 24px;display:flex;justify-content:space-between;align-items:center;gap:16px;">

        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:48px;height:48px;border-radius:50%;background:#eeeeff;color:#6366f1;font-size:18px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-size:15px;font-weight:700;color:var(--text-primary);">{{ auth()->user()->name }}</div>
                <div style="font-size:12px;color:var(--text-muted);">{{ ucfirst(auth()->user()->role ?? 'Employee') }}</div>
            </div>
        </div>

        <div style="text-align:center;">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:4px;">Current Time</div>
            <div id="clock" style="font-size:22px;font-weight:700;color:#6366f1;font-family:'DM Mono',monospace;"></div>
        </div>

        <div>
            @if(!$attendanceToday)
                <form method="POST" action="{{ route('attendance.timeIn') }}">
                    @csrf
                    <button style="padding:10px 28px;border-radius:10px;background:#10b981;color:#fff;border:none;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;">
                        <i class="bi bi-box-arrow-in-right"></i> Time In
                    </button>
                </form>
            @elseif(in_array($attendanceToday->status, ['Absent', 'On Leave']))
                <button disabled style="padding:10px 28px;border-radius:10px;background:#f1f5f9;color:#94a3b8;border:1px solid var(--border);font-size:13.5px;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;">
                    {{ $attendanceToday->status }}
                </button>
            @elseif(!$attendanceToday->time_out)
                <form method="POST" action="{{ route('attendance.timeOut') }}">
                    @csrf
                    <button style="padding:10px 28px;border-radius:10px;background:#ef4444;color:#fff;border:none;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;">
                        <i class="bi bi-box-arrow-right"></i> Time Out
                    </button>
                </form>
            @else
                <button disabled style="padding:10px 28px;border-radius:10px;background:#f0fdf4;color:#10b981;border:1px solid rgba(16,185,129,.2);font-size:13.5px;font-weight:600;display:inline-flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;">
                    <i class="bi bi-check-circle"></i> Completed
                </button>
            @endif
        </div>
    </div>

    @if($attendanceToday)
    <div style="display:flex;border-top:1px solid var(--border);">
        <div style="flex:1;text-align:center;padding:14px;border-right:1px solid var(--border);">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Status</div>
            @if($attendanceToday->status == 'Present')
                <span class="badge-status badge-present">Present</span>
            @elseif($attendanceToday->status == 'Late')
                <span class="badge-status badge-late">Late</span>
            @elseif($attendanceToday->status == 'Absent')
                <span class="badge-status badge-absent">Absent</span>
            @elseif($attendanceToday->status == 'On Leave')
                <span class="badge-status badge-on-leave">On Leave</span>
            @else
                <span class="badge-status badge-on-leave">{{ $attendanceToday->status }}</span>
            @endif
        </div>
        <div style="flex:1;text-align:center;padding:14px;border-right:1px solid var(--border);">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Time In</div>
            <div style="font-size:14px;font-weight:600;color:var(--text-primary);font-family:'DM Mono',monospace;">
                {{ $attendanceToday->time_in ? \Carbon\Carbon::parse($attendanceToday->time_in)->format('h:i A') : '—' }}
            </div>
        </div>
        <div style="flex:1;text-align:center;padding:14px;">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Time Out</div>
            <div style="font-size:14px;font-weight:600;color:var(--text-primary);font-family:'DM Mono',monospace;">
                {{ $attendanceToday->time_out ? \Carbon\Carbon::parse($attendanceToday->time_out)->format('h:i A') : '—' }}
            </div>
        </div>
    </div>
    @endif
</div>

<div class="data-card">
    <div class="data-card-header">
        <span class="data-card-title">Attendance History</span>
        <form method="GET" style="display:flex;gap:8px;align-items:center;">
            <select name="status"
                style="padding:7px 12px;border-radius:10px;border:1px solid var(--border);font-size:13px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;outline:none;">
                <option value="">All Status</option>
                <option value="Present"  {{ request('status') == 'Present'  ? 'selected' : '' }}>Present</option>
                <option value="Late"     {{ request('status') == 'Late'     ? 'selected' : '' }}>Late</option>
                <option value="Absent"   {{ request('status') == 'Absent'   ? 'selected' : '' }}>Absent</option>
                <option value="On Leave" {{ request('status') == 'On Leave' ? 'selected' : '' }}>On Leave</option>
            </select>
            <input type="date" name="date" value="{{ request('date') }}"
                style="padding:7px 12px;border-radius:10px;border:1px solid var(--border);font-size:13px;color:var(--text-primary);background:#fff;font-family:'DM Mono',monospace;outline:none;">
            <button type="submit"
                style="padding:7px 16px;background:#6366f1;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;display:inline-flex;align-items:center;gap:6px;">
                <i class="bi bi-funnel"></i> Filter
            </button>
            @if(request('status') || request('date'))
                <a href="{{ route('attendance.index') }}"
                    style="padding:7px 12px;background:#fff;color:var(--text-muted);border:1px solid var(--border);border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </form>
    </div>
    <div style="overflow-x:auto;">
        <table class="hris-table">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Date</th>
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
                    <td style="font-weight:600;font-size:13px;">{{ \Carbon\Carbon::parse($att->attendance_date)->format('l') }}</td>
                    <td style="color:var(--text-muted);font-size:13px;font-family:'DM Mono',monospace;">{{ \Carbon\Carbon::parse($att->attendance_date)->format('M d, Y') }}</td>
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
                        @else
                            <span class="badge-status badge-on-leave">{{ $att->status }}</span>
                        @endif
                    </td>
                    <td style="font-weight:600;font-size:13px;font-family:'DM Mono',monospace;">{{ $att->hours_worked ?? 0 }} hrs</td>
                    <td style="font-size:13px;color:var(--text-muted);">{{ $att->remarks ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:40px 22px;color:var(--text-muted);font-size:13.5px;">
                        <i class="bi bi-calendar-x" style="font-size:24px;display:block;margin-bottom:8px;opacity:.4;"></i>
                        No attendance records found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    setInterval(() => {
        document.getElementById("clock").innerText = new Date().toLocaleTimeString();
    }, 1000);
    document.getElementById("clock").innerText = new Date().toLocaleTimeString();
</script>
@endpush

@endsection