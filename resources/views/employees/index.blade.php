@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:var(--text-primary)">Employees</h4>
        <p class="mb-0" style="font-size:13px;color:var(--text-muted)">Manage your workforce</p>
    </div>
    <a href="{{ route('employees.create') }}" class="btn btn-sm d-flex align-items-center gap-2"
       style="background:#6366f1;color:#fff;border-radius:10px;padding:8px 16px;font-weight:600;font-size:13px;border:none;">
        <i class="bi bi-plus-circle"></i> Add Employee
    </a>
</div>

<div class="data-card" style="margin-bottom:16px;">
    <div style="padding:16px 22px;">
        <form method="GET" action="{{ route('employees.index') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">

            <div style="flex:1;min-width:200px;">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Search</label>
                <input
                    type="text"
                    name="search"
                    placeholder="Search name or email…"
                    value="{{ request('search') }}"
                    style="width:100%;padding:9px 14px;border-radius:10px;border:1px solid var(--border);font-size:13px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;outline:none;box-sizing:border-box;">
            </div>

            <div style="flex:1;min-width:180px;">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Department</label>
                <select name="department"
                    style="width:100%;padding:9px 14px;border-radius:10px;border:1px solid var(--border);font-size:13px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;outline:none;">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ✅ NEW: Status filter --}}
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
                @if(request('search') || request('department') || request('status'))
                    <a href="{{ route('employees.index') }}"
                        style="padding:9px 16px;background:#fff;color:var(--text-muted);border:1px solid var(--border);border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;">
                        <i class="bi bi-x-lg"></i> Clear
                    </a>
                @endif
            </div>

        </form>
    </div>
</div>
{{-- TABLE --}}
<div class="data-card">
    <div class="data-card-header">
        <span class="data-card-title">Employee List</span>
        <span style="font-size:12px;color:var(--text-muted)">{{ $employees->total() ?? count($employees) }} employees</span>
    </div>
    <div class="table-responsive">
        <table class="hris-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                <tr>
                    <td>
                        <div class="emp-info">
                            <div class="emp-avatar" style="font-size:12px;">
                                {{ strtoupper(substr($emp->first_name,0,1)) }}{{ strtoupper(substr($emp->last_name,0,1)) }}
                            </div>
                            <span class="emp-name">{{ $emp->first_name }} {{ $emp->last_name }}</span>
                        </div>
                    </td>
                    <td style="color:var(--text-muted);font-size:13px;">{{ $emp->email }}</td>
                    <td>{{ optional($emp->department)->name ?? '—' }}</td>
                    <td style="color:var(--text-muted);font-size:13px;">{{ $emp->position }}</td>
                    <td>
                        @if($emp->employment_status == 'active')
                            <span class="badge-status badge-present">Active</span>
                        @elseif($emp->employment_status == 'inactive')
                            <span class="badge-status" style="background:rgba(100,116,139,.1);color:#64748b;">
                                <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;margin-right:4px;"></span>Inactive
                            </span>
                        @else
                            <span class="badge-status badge-rejected">Terminated</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('employees.edit', $emp) }}"
                               style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;background:#f0f0fd;color:#6366f1;border:1px solid #e0e0fb;text-decoration:none;">
                                <i class="bi bi-pencil-square" style="font-size:13px;"></i>
                            </a>
                            <form action="{{ route('employees.destroy', $emp) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete this employee?')"
                                        style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;background:#fff5f5;color:#ef4444;border:1px solid #fde8e8;cursor:pointer;">
                                    <i class="bi bi-trash" style="font-size:13px;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:40px;color:var(--text-muted);">
                        <i class="bi bi-people" style="font-size:28px;display:block;margin-bottom:8px;opacity:.4;"></i>
                        No employees found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- PAGINATION --}}
@if(method_exists($employees, 'links'))
<div class="mt-3 d-flex justify-content-end" style="font-size:13px;">
    {{ $employees->withQueryString()->links() }}
</div>
@endif

@endsection