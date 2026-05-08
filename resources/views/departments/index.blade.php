@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:var(--text-primary)">Departments</h4>
        <p class="mb-0" style="font-size:13px;color:var(--text-muted)">Manage your organization's departments</p>
    </div>
    @if(auth()->user()->role != 'manager')
        <a href="{{ route('departments.create') }}"
           style="background:#6366f1;color:#fff;border-radius:10px;padding:8px 16px;font-weight:600;font-size:13px;border:none;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
            <i class="bi bi-plus-circle"></i> Add Department
        </a>
    @endif
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

{{-- SEARCH + FILTER --}}
<div class="data-card" style="margin-bottom:16px;">
    <div style="padding:16px 22px;">
        <form method="GET" action="{{ route('departments.index') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">

            <div style="flex:2;min-width:200px;">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Department Name</label>
                <input
                    type="text"
                    name="search"
                    placeholder="Search by name…"
                    value="{{ request('search') }}"
                    style="width:100%;padding:9px 14px;border-radius:10px;border:1px solid var(--border);font-size:13px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;outline:none;">
            </div>

            <div style="flex:1;min-width:160px;">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Status</label>
                <select name="status"
                    style="width:100%;padding:9px 14px;border-radius:10px;border:1px solid var(--border);font-size:13px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;outline:none;">
                    <option value="">All Status</option>
                    <option value="active"   {{ request('status') == 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div style="display:flex;gap:8px;">
                <button type="submit"
                    style="padding:9px 20px;background:#6366f1;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('departments.index') }}"
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
        <span class="data-card-title">Department List</span>
        <span style="font-size:12px;color:var(--text-muted)">{{ $departments->count() }} departments</span>
    </div>
    <div class="table-responsive">
        <table class="hris-table">
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Manager</th>
                    <th>Status</th>
                    @if(auth()->user()->role != 'manager')
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $dept)
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:13.5px;color:var(--text-primary);">{{ $dept->name }}</div>
                    </td>
                    <td>
                        @if($dept->manager)
                            <div class="emp-info">
                                <div class="emp-avatar" style="font-size:11px;width:28px;height:28px;">
                                    {{ strtoupper(substr($dept->manager->name, 0, 1)) }}
                                </div>
                                <span style="font-size:13px;">{{ $dept->manager->name }}</span>
                            </div>
                        @else
                            <span style="font-size:13px;color:var(--text-muted);">—</span>
                        @endif
                    </td>
                    <td>
                        @if($dept->status == 'active')
                            <span class="badge-status badge-present">Active</span>
                        @else
                            <span class="badge-status" style="background:rgba(100,116,139,.1);color:#64748b;">
                                <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;margin-right:4px;"></span>Inactive
                            </span>
                        @endif
                    </td>
                    @if(auth()->user()->role != 'manager')
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('departments.edit', $dept) }}"
                               style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;background:#f0f0fd;color:#6366f1;border:1px solid #e0e0fb;text-decoration:none;">
                                <i class="bi bi-pencil-square" style="font-size:13px;"></i>
                            </a>
                            <form action="{{ route('departments.destroy', $dept) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete this department?')"
                                        style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;background:#fff5f5;color:#ef4444;border:1px solid #fde8e8;cursor:pointer;">
                                    <i class="bi bi-trash" style="font-size:13px;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role != 'manager' ? 4 : 3 }}"
                        style="text-align:center;padding:40px;color:var(--text-muted);">
                        <i class="bi bi-diagram-3" style="font-size:28px;display:block;margin-bottom:8px;opacity:.4;"></i>
                        No departments found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection