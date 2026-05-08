@extends('layouts.app')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-0" style="color:var(--text-primary)">Employee Profile</h4>
    <p class="mb-0" style="font-size:13px;color:var(--text-muted)">Overview of personal and employment information</p>
</div>

@if(session('success'))
    <div class="mb-3 p-3" style="background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.2);border-radius:10px;color:#059669;font-size:13px;">
        {{ session('success') }}
    </div>
@endif

<div class="row g-4">

    {{-- Left: Avatar card --}}
    <div class="col-lg-3">
        <div class="data-card h-100">
            <div class="p-4 text-center">
                <div style="width:72px;height:72px;border-radius:50%;background:#eeeeff;color:#6366f1;font-size:26px;font-weight:700;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    {{ strtoupper(substr($employee->first_name,0,1)) }}{{ strtoupper(substr($employee->last_name,0,1)) }}
                </div>
                <div class="fw-bold mb-1" style="font-size:15px;color:var(--text-primary);">
                    {{ $employee->first_name }} {{ $employee->last_name }}
                </div>
                <div style="font-size:13px;color:var(--text-muted);margin-bottom:12px;">{{ $employee->position }}</div>
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
            <div style="border-top:1px solid var(--border);padding:16px 20px;">
                <div class="mb-3">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Email</div>
                    <div style="font-size:13px;color:var(--text-primary);">{{ $employee->email }}</div>
                </div>
                <div class="mb-3">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Phone</div>
                    <div style="font-size:13px;color:var(--text-primary);">{{ $employee->phone ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Department</div>
                    <div style="font-size:13px;color:var(--text-primary);">{{ $employee->department->name ?? 'Unassigned' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Info cards --}}
    <div class="col-lg-9">

        {{-- Personal Info --}}
        <div class="data-card mb-4">
            <div class="data-card-header">
                <span class="data-card-title">Personal Information</span>
            </div>
            <div class="p-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">First Name</div>
                        <div style="font-size:13.5px;font-weight:600;color:var(--text-primary);">{{ $employee->first_name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Last Name</div>
                        <div style="font-size:13.5px;font-weight:600;color:var(--text-primary);">{{ $employee->last_name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Email Address</div>
                        <div style="font-size:13.5px;font-weight:600;color:var(--text-primary);">{{ $employee->email }}</div>
                    </div>
                    <div class="col-md-6">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Contact Number</div>
                        <div style="font-size:13.5px;font-weight:600;color:var(--text-primary);">{{ $employee->phone ?? '—' }}</div>
                    </div>
                    <div class="col-12">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Residential Address</div>
                        <div style="font-size:13.5px;font-weight:600;color:var(--text-primary);">{{ $employee->address ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Employment Info --}}
        <div class="data-card">
            <div class="data-card-header">
                <span class="data-card-title">Employment Information</span>
            </div>
            <div class="p-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Job Title</div>
                        <div style="font-size:13.5px;font-weight:600;color:var(--text-primary);">{{ $employee->position }}</div>
                    </div>
                    <div class="col-md-6">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Department</div>
                        <div style="font-size:13.5px;font-weight:600;color:var(--text-primary);">{{ $employee->department->name ?? 'Unassigned' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Date Hired</div>
                        <div style="font-size:13.5px;font-weight:600;color:var(--text-primary);">
                            {{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('F d, Y') : '—' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Employment Status</div>
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
            </div>
        </div>

    </div>
</div>

@endsection