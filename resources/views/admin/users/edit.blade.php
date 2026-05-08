@extends('layouts.app')

@section('content')

<div class="mb-4">
    <h4 style="font-size:20px;font-weight:700;color:var(--text-primary);margin:0;">Edit User</h4>
    <p style="font-size:13px;color:var(--text-muted);margin:4px 0 0;">Update account details for {{ $user->name }}.</p>
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

<div class="data-card">
    <div class="data-card-header">
        <div style="display:flex;align-items:center;gap:12px;">
            <div class="emp-avatar" style="font-size:13px;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-size:14px;font-weight:700;color:var(--text-primary);">{{ $user->name }}</div>
                <div style="font-size:12px;color:var(--text-muted);">{{ $user->email }}</div>
            </div>
        </div>
        <span class="badge-status {{ $user->role === 'hr' ? 'badge-approved' : 'badge-pending' }}">
            {{ ucfirst($user->role) }}
        </span>
    </div>
    <div style="padding:24px;">
        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                <div>
                    <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:8px;">Full Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" required placeholder="e.g. Juan Dela Cruz"
                        style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid var(--border);font-size:13.5px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;box-sizing:border-box;outline:none;">
                </div>
                <div>
                    <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:8px;">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" required placeholder="e.g. juan@company.com"
                        style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid var(--border);font-size:13.5px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;box-sizing:border-box;outline:none;">
                </div>
                <div style="grid-column:1/-1;">
                    <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:8px;">Role</label>
                    <select name="role" required
                        style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid var(--border);font-size:13.5px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;outline:none;">
                        <option value="hr" {{ $user->role == 'hr' ? 'selected' : '' }}>HR</option>
                        <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager</option>
                    </select>
                </div>
            </div>

            <div style="display:flex;gap:10px;">
                <button type="submit"
                    style="padding:10px 24px;background:#6366f1;color:#fff;border:none;border-radius:10px;font-size:13.5px;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;">
                    <i class="bi bi-save me-1"></i> Save Changes
                </button>
                <a href="{{ route('users.index') }}"
                    style="padding:10px 20px;background:#fff;color:var(--text-muted);border:1px solid var(--border);border-radius:10px;font-size:13.5px;font-weight:600;text-decoration:none;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection