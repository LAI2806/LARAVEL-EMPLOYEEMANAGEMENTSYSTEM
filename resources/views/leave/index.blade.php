@extends('layouts.app')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="font-size:20px;font-weight:700;color:var(--text-primary);margin:0;">Leave Requests</h4>
        <p style="font-size:13px;color:var(--text-muted);margin:4px 0 0;">
            {{ auth()->user()->role === 'employee' ? 'Your leave history' : 'Manage leave requests' }}
        </p>
    </div>
    @if(auth()->user()->role === 'employee')
        <a href="{{ route('leave.create') }}"
           style="display:inline-flex;align-items:center;gap:8px;padding:9px 20px;background:#6366f1;color:#fff;border-radius:10px;font-size:13.5px;font-weight:600;text-decoration:none;border:none;">
            <i class="bi bi-plus-lg"></i> Apply Leave
        </a>
    @endif
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

{{-- Filters --}}
<div class="data-card" style="margin-bottom:16px;">
    <div style="padding:16px 22px;">
        <form method="GET" action="{{ route('leave.index') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">

            <div style="flex:1;min-width:160px;">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Status</label>
                <select name="status"
                    style="width:100%;padding:9px 14px;border-radius:10px;border:1px solid var(--border);font-size:13px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;outline:none;">
                    <option value="">All Statuses</option>
                    @foreach(['pending','approved','rejected'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>

            <div style="flex:1;min-width:200px;">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Leave Type</label>
                <select name="leave_type"
                    style="width:100%;padding:9px 14px;border-radius:10px;border:1px solid var(--border);font-size:13px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;outline:none;">
                    <option value="">All Types</option>
                    @foreach(['Vacation Leave','Sick Leave','Emergency Leave','Maternity Leave','Paternity Leave','Solo Parent Leave'] as $type)
                        <option value="{{ $type }}" {{ request('leave_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display:flex;gap:8px;">
                <button type="submit"
                    style="padding:9px 20px;background:#6366f1;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                @if(request('status') || request('leave_type'))
                    <a href="{{ route('leave.index') }}"
                        style="padding:9px 16px;background:#fff;color:var(--text-muted);border:1px solid var(--border);border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;">
                        <i class="bi bi-x-lg"></i> Clear
                    </a>
                @endif
            </div>

        </form>
    </div>
</div>

<div class="data-card">
    <div class="data-card-header">
        <span class="data-card-title">All Requests</span>
        <span style="font-size:12px;color:var(--text-muted);">{{ $leaves->count() }} total</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="hris-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaves as $leave)
                <tr>
                    <td>
                        <div class="emp-info">
                            <div class="emp-avatar" style="font-size:11px;">
                                {{ strtoupper(substr($leave->employee->user->name ?? 'N', 0, 1)) }}
                            </div>
                            <span class="emp-name">{{ $leave->employee->user->name ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td style="font-size:13px;">{{ $leave->leave_type }}</td>
                    <td style="font-family:'DM Mono',monospace;font-size:13px;">{{ \Carbon\Carbon::parse($leave->start_date)->format('Y-m-d') }}</td>
                    <td style="font-family:'DM Mono',monospace;font-size:13px;">{{ \Carbon\Carbon::parse($leave->end_date)->format('Y-m-d') }}</td>
                    <td style="font-size:13px;color:var(--text-muted);max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $leave->reason ?? '—' }}
                    </td>
                    <td>
                        <span class="badge-status
                            {{ $leave->status === 'approved' ? 'badge-approved' :
                               ($leave->status === 'rejected' ? 'badge-rejected' : 'badge-pending') }}">
                            {{ ucfirst($leave->status) }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;align-items:center;">
                            <a href="{{ route('leave.show', $leave->id) }}"
                               style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;border:1px solid var(--border);color:var(--text-muted);text-decoration:none;font-size:14px;background:#fff;"
                               title="View">
                                <i class="bi bi-eye"></i>
                            </a>

                            @if(in_array(auth()->user()->role, ['manager', 'admin']) && $leave->status === 'pending')
                                <form method="POST" action="{{ route('leave.approve', $leave->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" title="Approve"
                                        style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;border:1px solid rgba(16,185,129,.3);color:#10b981;background:rgba(16,185,129,.08);cursor:pointer;font-size:14px;">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('leave.reject', $leave->id) }}" style="display:inline;"
                                      onsubmit="return confirm('Reject this leave request?')">
                                    @csrf
                                    <button type="submit" title="Reject"
                                        style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;border:1px solid rgba(239,68,68,.3);color:#ef4444;background:rgba(239,68,68,.08);cursor:pointer;font-size:14px;">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                            @endif

                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('leave.edit', $leave->id) }}"
                                   style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;border:1px solid rgba(99,102,241,.3);color:#6366f1;background:rgba(99,102,241,.08);text-decoration:none;font-size:14px;"
                                   title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            @endif

                            @if(auth()->user()->role === 'admin')
                                <form method="POST" action="{{ route('leave.destroy', $leave->id) }}" style="display:inline;"
                                    onsubmit="return confirm('Delete this leave request?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete"
                                        style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;border:1px solid rgba(239,68,68,.3);color:#ef4444;background:rgba(239,68,68,.08);cursor:pointer;font-size:14px;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:40px 22px;color:var(--text-muted);font-size:13.5px;">
                        <i class="bi bi-inbox" style="font-size:24px;display:block;margin-bottom:8px;opacity:.4;"></i>
                        No leave requests found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection