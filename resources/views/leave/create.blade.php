@extends('layouts.app')

@section('content')

<div class="mb-4">
    <h4 style="font-size:20px;font-weight:700;color:var(--text-primary);margin:0;">Apply for Leave</h4>
    <p style="font-size:13px;color:var(--text-muted);margin:4px 0 0;">Fill in the details below to submit a leave request.</p>
</div>

@if($errors->any())
    <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);color:#dc2626;border-radius:10px;padding:12px 16px;font-size:13.5px;margin-bottom:16px;">
        <i class="bi bi-exclamation-circle me-2"></i>
        <ul style="margin:8px 0 0 16px;padding:0;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);color:#dc2626;border-radius:10px;padding:12px 16px;font-size:13.5px;margin-bottom:16px;">
        <i class="bi bi-exclamation-circle me-2"></i> {{ session('error') }}
    </div>
@endif

<div class="data-card">
    <div class="data-card-header">
        <span class="data-card-title">Leave Request Form</span>
    </div>
    <div style="padding:24px;">
        <form method="POST" action="{{ route('leave.store') }}">
            @csrf

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:8px;">
                    Leave Type
                </label>
                <select name="leave_type" required
                    style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid var(--border);font-size:13.5px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;outline:none;">
                    <option value="">Select Leave Type</option>
                    @foreach(['Vacation Leave','Sick Leave','Emergency Leave','Maternity Leave','Paternity Leave','Solo Parent Leave'] as $type)
                        <option value="{{ $type }}" {{ old('leave_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                <div>
                    <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:8px;">
                        Start Date
                    </label>
                    <input type="date" name="start_date"
                        value="{{ old('start_date') }}"
                        min="{{ date('Y-m-d') }}"
                        required
                        style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid var(--border);font-size:13.5px;color:var(--text-primary);background:#fff;font-family:'DM Mono',monospace;box-sizing:border-box;outline:none;">
                </div>
                <div>
                    <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:8px;">
                        End Date
                    </label>
                    <input type="date" name="end_date"
                        value="{{ old('end_date') }}"
                        min="{{ date('Y-m-d') }}"
                        required
                        style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid var(--border);font-size:13.5px;color:var(--text-primary);background:#fff;font-family:'DM Mono',monospace;box-sizing:border-box;outline:none;">
                </div>
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:8px;">
                    Reason <span style="font-weight:400;text-transform:none;letter-spacing:0;">(optional)</span>
                </label>
                <textarea name="reason" rows="4"
                    placeholder="Briefly describe your reason..."
                    style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid var(--border);font-size:13.5px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;resize:vertical;box-sizing:border-box;outline:none;">{{ old('reason') }}</textarea>
            </div>

            <div style="display:flex;gap:10px;">
                <button type="submit"
                    style="padding:10px 24px;background:#6366f1;color:#fff;border:none;border-radius:10px;font-size:13.5px;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;">
                    <i class="bi bi-send me-1"></i> Submit Request
                </button>
                <a href="{{ route('leave.index') }}"
                    style="padding:10px 20px;background:#fff;color:var(--text-muted);border:1px solid var(--border);border-radius:10px;font-size:13.5px;font-weight:600;text-decoration:none;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection