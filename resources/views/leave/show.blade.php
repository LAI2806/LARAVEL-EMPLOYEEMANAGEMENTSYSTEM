@extends('layouts.app')

@section('content')

<div class="mb-4">
    <h4 style="font-size:20px;font-weight:700;color:var(--text-primary);margin:0;">Leave Request Details</h4>
    <p style="font-size:13px;color:var(--text-muted);margin:4px 0 0;">Viewing full details of this request.</p>
</div>


<div class="data-card">
    <div class="data-card-header">
        <div style="display:flex;align-items:center;gap:12px;">
            <div class="emp-avatar" style="width:38px;height:38px;font-size:13px;">
                {{ strtoupper(substr($leave->employee->user->name ?? 'N', 0, 1)) }}
            </div>
            <div>
                <div style="font-size:14px;font-weight:700;color:var(--text-primary);">{{ $leave->employee->user->name ?? 'N/A' }}</div>
                <div style="font-size:12px;color:var(--text-muted);">{{ $leave->leave_type }}</div>
            </div>
        </div>
        <span class="badge-status
            {{ $leave->status === 'approved' ? 'badge-approved' :
               ($leave->status === 'rejected' ? 'badge-rejected' : 'badge-pending') }}">
            {{ ucfirst($leave->status) }}
        </span>
    </div>

    <div style="padding:24px;display:grid;grid-template-columns:1fr 1fr;gap:14px;">

        <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;border:1px solid var(--border);">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Employee</div>
            <div style="font-size:14px;font-weight:600;color:var(--text-primary);">{{ $leave->employee->user->name ?? 'N/A' }}</div>
        </div>

        <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;border:1px solid var(--border);">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Leave Type</div>
            <div style="font-size:14px;font-weight:600;color:var(--text-primary);">{{ $leave->leave_type }}</div>
        </div>

        <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;border:1px solid var(--border);">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Start Date</div>
           <td style="font-family:'DM Mono',monospace;font-size:13px;">{{ $leave->start_date->format('Y-m-d') }}</td>
        </div>

        <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;border:1px solid var(--border);">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">End Date</div>
            <td style="font-family:'DM Mono',monospace;font-size:13px;">{{ $leave->end_date->format('Y-m-d') }}</td>
        </div>

        <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;border:1px solid var(--border);grid-column:1/-1;">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Reason</div>
            <div style="font-size:14px;color:var(--text-primary);">{{ $leave->reason ?? '—' }}</div>
        </div>

        <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;border:1px solid var(--border);">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Processed By</div>
            <div style="font-size:14px;font-weight:600;color:var(--text-primary);">
                @if($leave->approved_by)
                    {{ $leave->approver->name }}
                @elseif($leave->approved_at)
                    <span style="color:#94a3b8;font-style:italic;font-weight:400;">Auto-expired by system</span>
                @else
                    —
                @endif
            </div>
        </div>

        <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;border:1px solid var(--border);">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Processed At</div>
            <div style="font-size:14px;font-weight:600;color:var(--text-primary);font-family:'DM Mono',monospace;">
                {{ $leave->approved_at ? \Carbon\Carbon::parse($leave->approved_at)->format('M d, Y h:i A') : '—' }}
            </div>
        </div>
    </div>

    <div style="padding:0 24px 24px;display:flex;gap:10px;">
        <a href="{{ route('leave.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;background:#fff;color:var(--text-muted);border:1px solid var(--border);border-radius:10px;font-size:13.5px;font-weight:600;text-decoration:none;">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('leave.edit', $leave->id) }}"
               style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;background:rgba(99,102,241,.08);color:#6366f1;border:1px solid rgba(99,102,241,.3);border-radius:10px;font-size:13.5px;font-weight:600;text-decoration:none;">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
        @endif
    </div>
</div>

@endsection