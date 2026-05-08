@extends('layouts.app')

@section('content')

<div class="mb-4">
    <div class="d-flex align-items-center gap-2 mb-1">
        <a href="{{ url()->previous() }}"
           style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#f4f4fb;color:#6366f1;border:1px solid #e0e0fb;text-decoration:none;">
            <i class="bi bi-arrow-left" style="font-size:13px;"></i>
        </a>
        <h4 class="fw-bold mb-0" style="color:var(--text-primary)">Employee Profile</h4>
    </div>
    <p class="mb-0" style="font-size:13px;color:var(--text-muted);margin-left:36px;">Personal and employment details</p>
</div>

<div class="data-card">

    {{-- Profile header --}}
    <div class="p-4 d-flex align-items-center gap-3" style="border-bottom:1px solid var(--border);">
        <div style="width:56px;height:56px;border-radius:50%;background:#eeeeff;color:#6366f1;font-size:20px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            {{ strtoupper(substr($employee->first_name,0,1)) }}{{ strtoupper(substr($employee->last_name,0,1)) }}
        </div>
        <div class="flex-fill">
            <div class="fw-bold" style="font-size:15px;color:var(--text-primary);">
                {{ $employee->first_name }} {{ $employee->last_name }}
            </div>
            <div style="font-size:13px;color:var(--text-muted);">{{ $employee->position }}</div>
        </div>
        <div>
            @if($employee->employment_status === 'active')
                <span class="badge-status badge-present">Active</span>
            @elseif($employee->employment_status === 'inactive')
                <span class="badge-status" style="background:rgba(100,116,139,.1);color:#64748b;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;margin-right:4px;"></span>Inactive
                </span>
            @else
                <span class="badge-status badge-rejected">Terminated</span>
            @endif
        </div>
    </div>

    {{-- Details grid --}}
    <div class="p-4">
        <div class="row g-4">
            <div class="col-md-6">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Email Address</div>
                <div style="font-size:13.5px;font-weight:600;color:var(--text-primary);">{{ $employee->email }}</div>
            </div>
            <div class="col-md-6">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Contact Number</div>
                <div style="font-size:13.5px;font-weight:600;color:var(--text-primary);">{{ $employee->phone ?? '—' }}</div>
            </div>
            <div class="col-md-6">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Department</div>
                <div style="font-size:13.5px;font-weight:600;color:var(--text-primary);">{{ $employee->department->name ?? '—' }}</div>
            </div>
            <div class="col-md-6">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Date Hired</div>
                <div style="font-size:13.5px;font-weight:600;color:var(--text-primary);">
                    {{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('M d, Y') : '—' }}
                </div>
            </div>
            <div class="col-12">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Residential Address</div>
                <div style="font-size:13.5px;font-weight:600;color:var(--text-primary);">{{ $employee->address ?? '—' }}</div>
            </div>
        </div>
    </div>

</div>

@endsection