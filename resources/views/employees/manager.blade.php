@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:var(--text-primary)">My Team</h4>
        <p class="mb-0" style="font-size:13px;color:var(--text-muted)">Overview of employees in your department</p>
    </div>
</div>

@if(session('success'))
    <div class="mb-3 p-3" style="background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.2);border-radius:10px;color:#059669;font-size:13px;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-3 p-3" style="background:#fff5f5;border:1px solid #fde8e8;border-radius:10px;color:#ef4444;font-size:13px;">
        {{ session('error') }}
    </div>
@endif

<div class="data-card" style="margin-bottom:16px;">
    <div style="padding:16px 22px;">
        <form method="GET" action="{{ route('manager.employees.index') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">

            <div style="flex:1;min-width:200px;">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Search</label>
                <input
                    type="text"
                    name="search"
                    placeholder="Search name or email…"
                    value="{{ request('search') }}"
                    style="width:100%;padding:9px 14px;border-radius:10px;border:1px solid var(--border);font-size:13px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;outline:none;box-sizing:border-box;">
            </div>

            <div style="flex:1;min-width:160px;">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Status</label>
                <select name="status"
                    style="width:100%;padding:9px 14px;border-radius:10px;border:1px solid var(--border);font-size:13px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;outline:none;">
                    <option value="">All Status</option>
                    @foreach(['active','inactive','terminated'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display:flex;gap:8px;">
                <button type="submit"
                    style="padding:9px 20px;background:#6366f1;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('manager.employees.index') }}"
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
        <span class="data-card-title">Department Employees</span>
        <span style="font-size:12px;color:var(--text-muted)">
            {{ $employees->count() }} {{ Str::plural('Employee', $employees->count()) }}
        </span>
    </div>
    <div class="table-responsive">
        <table class="hris-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Hire Date</th>
                    <th style="text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr>
                    <td>
                        <div class="emp-info">
                            <div class="emp-avatar">
                                {{ strtoupper(substr($employee->first_name,0,1)) }}{{ strtoupper(substr($employee->last_name,0,1)) }}
                            </div>
                            <div>
                                <div class="emp-name">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                <div class="emp-pos">Employee</div>
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--text-muted);font-size:13px;">{{ $employee->email }}</td>
                    <td>
                        <span style="background:#f4f4fb;color:#6366f1;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;">
                            {{ $employee->position }}
                        </span>
                    </td>
                    <td>
                        @if($employee->employment_status === 'active')
                            <span class="badge-status badge-present">Active</span>
                        @elseif($employee->employment_status === 'terminated')
                            <span class="badge-status badge-rejected">Terminated</span>
                        @else
                            <span class="badge-status" style="background:rgba(100,116,139,.1);color:#64748b;">
                                <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;margin-right:4px;"></span>
                                {{ ucfirst($employee->employment_status) }}
                            </span>
                        @endif
                    </td>
                    <td style="color:var(--text-muted);font-size:13px;">
                        {{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('M d, Y') : '—' }}
                    </td>
                    <td style="text-align:right;">
                        <a href="{{ route('manager.employees.show', $employee) }}"
                           style="display:inline-flex;align-items:center;gap:5px;padding:6px 14px;border-radius:8px;background:#f0f0fd;color:#6366f1;border:1px solid #e0e0fb;font-size:12px;font-weight:600;text-decoration:none;">
                            <i class="bi bi-eye" style="font-size:12px;"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:40px;color:var(--text-muted);">
                        <i class="bi bi-people" style="font-size:28px;display:block;margin-bottom:8px;opacity:.4;"></i>
                        No employees found in your department.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection