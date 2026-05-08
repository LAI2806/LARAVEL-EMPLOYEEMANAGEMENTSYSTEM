@extends('layouts.app')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="font-size:20px;font-weight:700;color:var(--text-primary);margin:0;">Users</h4>
        <p style="font-size:13px;color:var(--text-muted);margin:4px 0 0;">Manage HR and Manager accounts</p>
    </div>
    <a href="{{ route('users.create') }}"
       style="display:inline-flex;align-items:center;gap:8px;padding:9px 20px;background:#6366f1;color:#fff;border-radius:10px;font-size:13.5px;font-weight:600;text-decoration:none;">
        <i class="bi bi-plus-lg"></i> Add User
    </a>
</div>

@if(session('success'))
    <div style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.25);color:#059669;border-radius:10px;padding:12px 16px;font-size:13.5px;margin-bottom:16px;">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif
<div class="data-card mb-4">
    <div style="padding:16px 22px;">
        <form method="GET" action="{{ route('users.index') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">

            <div style="flex:2;min-width:200px;">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Search</label>
                <input type="text" name="search"
                       placeholder="Search name or email…"
                       value="{{ request('search') }}"
                       style="width:100%;padding:9px 14px;border-radius:10px;border:1px solid var(--border);font-size:13px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;outline:none;box-sizing:border-box;">
            </div>

            <div style="flex:1;min-width:160px;">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Role</label>
                <select name="status"
                    style="width:100%;padding:9px 14px;border-radius:10px;border:1px solid var(--border);font-size:13px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;outline:none;">
                    <option value="">All Roles</option>
                    @foreach(['admin' => 'Admin', 'hr' => 'HR', 'manager' => 'Manager', 'employee' => 'Employee'] as $val => $label)
                        <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display:flex;gap:8px;align-items:flex-end;">
                <button type="submit"
                    style="padding:9px 20px;background:#6366f1;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;display:inline-flex;align-items:center;gap:6px;">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('users.index') }}"
                        style="padding:9px 12px;background:#fff;color:var(--text-muted);border:1px solid var(--border);border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>

        </form>
    </div>
</div>

<div class="data-card">
    <div class="data-card-header">
        <span class="data-card-title">All Users</span>
        <span style="font-size:12px;color:var(--text-muted);">{{ $users->count() }} total</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="hris-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="emp-info">
                            <div class="emp-avatar" style="font-size:12px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="emp-name">{{ $user->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:13px;color:var(--text-muted);">{{ $user->email }}</td>
                    <td>
                        <span class="badge-status {{ $user->role === 'admin' ? 'badge-on-leave' : ($user->role === 'hr' ? 'badge-approved' : 'badge-pending') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;align-items:center;">
                            <a href="{{ route('users.show', $user->id) }}"
                               style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;border:1px solid var(--border);color:var(--text-muted);text-decoration:none;font-size:14px;background:#fff;"
                               title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('users.edit', $user->id) }}"
                               style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;border:1px solid rgba(99,102,241,.3);color:#6366f1;background:rgba(99,102,241,.08);text-decoration:none;font-size:14px;"
                               title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('Delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete"
                                    style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;border:1px solid rgba(239,68,68,.3);color:#ef4444;background:rgba(239,68,68,.08);cursor:pointer;font-size:14px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center;padding:40px 22px;color:var(--text-muted);font-size:13.5px;">
                        <i class="bi bi-people" style="font-size:24px;display:block;margin-bottom:8px;opacity:.4;"></i>
                        No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection