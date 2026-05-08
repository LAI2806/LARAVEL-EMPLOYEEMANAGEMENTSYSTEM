@extends('layouts.app')

@section('content')

<div class="mb-4">
    <div class="d-flex align-items-center gap-2 mb-1">
        <a href="{{ route('attendance.report') }}"
           style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#f4f4fb;color:#6366f1;border:1px solid #e0e0fb;text-decoration:none;">
            <i class="bi bi-arrow-left" style="font-size:13px;"></i>
        </a>
        <h4 class="fw-bold mb-0" style="color:var(--text-primary)">Edit Attendance Record</h4>
    </div>
    <p class="mb-0" style="font-size:13px;color:var(--text-muted);margin-left:36px;">Update the attendance details for this record.</p>
</div>

@if($errors->any())
    <div class="mb-3 p-3" style="background:#fff5f5;border:1px solid #fde8e8;border-radius:10px;color:#ef4444;font-size:13px;">
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="data-card">

    {{-- Record info header --}}
    <div class="p-3 d-flex align-items-center gap-3" style="border-bottom:1px solid var(--border);">
        <div class="emp-avatar" style="font-size:13px;">
            {{ strtoupper(substr($attendance->employee->user->name ?? 'N', 0, 1)) }}
        </div>
        <div>
            <div class="emp-name">{{ $attendance->employee->user->name ?? 'N/A' }}</div>
            <div class="emp-pos">{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('l, F d, Y') }}</div>
        </div>
    </div>

    <div class="data-card-header" style="border-bottom:1px solid var(--border);">
        <span class="data-card-title">Attendance Details</span>
    </div>

    <div class="p-3">
    <form method="POST" action="{{ route('attendance.update', $attendance->id) }}">
        @csrf @method('PUT')
        <input type="hidden" name="attendance_date" value="{{ $attendance->attendance_date }}">

            <div class="mb-3">
                <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Status</label>
                <select name="status" class="form-select form-select-sm" required style="border-radius:9px;font-size:13.5px;">
                    @foreach(['Present', 'Late', 'Absent', 'On Leave'] as $status)
                        <option value="{{ $status }}" {{ $attendance->status === $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Time In</label>
                    <input type="time" name="time_in" class="form-control form-control-sm"
                           value="{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('H:i') : '' }}"
                           style="border-radius:9px;font-size:13.5px;">
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Time Out</label>
                    <input type="time" name="time_out" class="form-control form-control-sm"
                           value="{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('H:i') : '' }}"
                           style="border-radius:9px;font-size:13.5px;">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Remarks</label>
                <input type="text" name="remarks" class="form-control form-control-sm"
                       value="{{ $attendance->remarks }}"
                       placeholder="e.g. Overtime, Undertime, Complete"
                       style="border-radius:9px;font-size:13.5px;">
            </div>

            <div class="d-flex justify-content-between align-items-center pt-3 mt-1" style="border-top:1px solid var(--border);">
                <a href="{{ route('attendance.report') }}"
                   style="padding:9px 18px;border-radius:10px;background:#f4f4fb;color:#6366f1;border:1px solid #e0e0fb;font-size:13.5px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                    <i class="bi bi-arrow-left" style="font-size:12px;"></i> Cancel
                </a>
                <button type="submit"
                        style="padding:9px 22px;border-radius:10px;background:#6366f1;color:#fff;border:none;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                    <i class="bi bi-floppy"></i> Save Changes
                </button>
            </div>

        </form>
    </div>
</div>

@endsection