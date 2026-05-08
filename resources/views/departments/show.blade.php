@extends('layouts.app')

@section('content')

<div class="mb-4">
    <div class="d-flex align-items-center gap-2 mb-1">
        <a href="{{ route('departments.index') }}"
           style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#f4f4fb;color:#6366f1;border:1px solid #e0e0fb;text-decoration:none;">
            <i class="bi bi-arrow-left" style="font-size:13px;"></i>
        </a>
        <h4 class="fw-bold mb-0" style="color:var(--text-primary)">{{ $department->name }}</h4>
    </div>
    <p class="mb-0" style="font-size:13px;color:var(--text-muted);margin-left:36px;">Department overview and assigned personnel</p>
</div>

<div class="row g-4">

    {{-- Left: Department info card --}}
    <div class="col-lg-3">
        <div class="data-card h-100">
            <div class="p-4 text-center">
                <div style="width:64px;height:64px;border-radius:50%;background:#eeeeff;color:#6366f1;font-size:24px;font-weight:700;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                    {{ strtoupper(substr($department->name, 0, 1)) }}
                </div>
                <div class="fw-bold mb-1" style="font-size:15px;color:var(--text-primary);">{{ $department->name }}</div>
                <div style="font-size:12px;color:var(--text-muted);">Department</div>
            </div>

            <div style="border-top:1px solid var(--border);padding:16px 20px;">
                <div class="mb-3">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Manager</div>
                    @if($department->manager)
                        <div class="emp-info" style="margin-top:4px;">
                            <div class="emp-avatar" style="font-size:11px;width:26px;height:26px;">
                                {{ strtoupper(substr($department->manager->name, 0, 1)) }}
                            </div>
                            <span style="font-size:13px;font-weight:600;color:var(--text-primary);">{{ $department->manager->name }}</span>
                        </div>
                    @else
                        <span style="font-size:13px;color:var(--text-muted);">Not Assigned</span>
                    @endif
                </div>

                <div class="mb-3">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:6px;">Status</div>
                    @if($department->status === 'active')
                        <span class="badge-status badge-present">Active</span>
                    @else
                        <span class="badge-status" style="background:rgba(100,116,139,.1);color:#64748b;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;margin-right:4px;"></span>Inactive
                        </span>
                    @endif
                </div>

                <div>
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:3px;">Description</div>
                    <div style="font-size:13px;color:var(--text-muted);line-height:1.5;">
                        {{ $department->description ?? 'No description provided.' }}
                    </div>
                </div>
            </div>

            @if(auth()->user()->role != 'manager')
            <div class="p-3" style="border-top:1px solid var(--border);">
                <a href="{{ route('departments.edit', $department) }}"
                   style="display:flex;align-items:center;justify-content:center;gap:6px;padding:8px;border-radius:9px;background:#f0f0fd;color:#6366f1;border:1px solid #e0e0fb;font-size:13px;font-weight:600;text-decoration:none;">
                    <i class="bi bi-pencil-square" style="font-size:13px;"></i> Edit Department
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Right: Employees list --}}
    <div class="col-lg-9">
        <div class="data-card">
            <div class="data-card-header">
                <span class="data-card-title">Assigned Employees</span>
                <span style="font-size:12px;color:var(--text-muted);">
                    {{ $department->employees->count() }} {{ Str::plural('Employee', $department->employees->count()) }}
                </span>
            </div>

            @if($department->employees->count())
                <table class="hris-table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Position</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($department->employees as $emp)
                        <tr>
                            <td>
                                <div class="emp-info">
                                    <div class="emp-avatar" style="font-size:11px;width:30px;height:30px;">
                                        {{ strtoupper(substr($emp->first_name,0,1)) }}{{ strtoupper(substr($emp->last_name,0,1)) }}
                                    </div>
                                    <div>
                                        <div class="emp-name">{{ $emp->first_name }} {{ $emp->last_name }}</div>
                                        <div class="emp-pos">{{ $emp->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:13px;color:var(--text-muted);">{{ $emp->position ?? '—' }}</td>
                            <td>
                                <span style="background:#f4f4fb;color:#6366f1;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;">
                                    {{ ucfirst($emp->user->role ?? '—') }}
                                </span>
                            </td>
                            <td>
                                @if($emp->employment_status === 'active')
                                    <span class="badge-status badge-present">Active</span>
                                @elseif($emp->employment_status === 'inactive')
                                    <span class="badge-status" style="background:rgba(100,116,139,.1);color:#64748b;">
                                        <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;margin-right:4px;"></span>Inactive
                                    </span>
                                @else
                                    <span class="badge-status badge-rejected">Terminated</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align:center;padding:48px;color:var(--text-muted);">
                    <i class="bi bi-people" style="font-size:28px;display:block;margin-bottom:8px;opacity:.4;"></i>
                    No employees assigned to this department.
                </div>
            @endif

        </div>
    </div>

</div>

@endsection