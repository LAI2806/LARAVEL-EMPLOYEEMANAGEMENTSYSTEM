@extends('layouts.app')

@section('content')
<style>
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px; }
    .form-actions { display:flex; gap:10px; }
    @media(max-width:640px){
        .form-grid { grid-template-columns:1fr; }
        .form-actions { flex-direction:column; }
        .form-actions button, .form-actions a { width:100%; text-align:center; box-sizing:border-box; }
    }
</style>

<div class="mb-4">
    <h4 style="font-size:20px;font-weight:700;color:var(--text-primary);margin:0;">Create New User</h4>
    <p style="font-size:13px;color:var(--text-muted);margin:4px 0 0;">Add a new HR or Manager account.</p>
</div>

@if(session('success'))
    <div style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.25);color:#059669;border-radius:10px;padding:12px 16px;font-size:13.5px;margin-bottom:16px;">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

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
        <span class="data-card-title">User Details</span>
    </div>
    <div style="padding:24px;">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="form-grid">
                <div>
                    <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:8px;">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Juan Dela Cruz"
                        style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid var(--border);font-size:13.5px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;box-sizing:border-box;outline:none;">
                </div>
                <div>
                    <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:8px;">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="e.g. juan@company.com"
                        style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid var(--border);font-size:13.5px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;box-sizing:border-box;outline:none;">
                </div>
                <div>
                    <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:8px;">Password</label>
                    <input type="password" name="password" required minlength="8" placeholder="Minimum 8 characters"
                        style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid var(--border);font-size:13.5px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;box-sizing:border-box;outline:none;">
                </div>
                <div>
                    <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:8px;">Role</label>
                    <select name="role" required
                        style="width:100%;padding:10px 14px;border-radius:10px;border:1px solid var(--border);font-size:13.5px;color:var(--text-primary);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;outline:none;">
                        <option value="hr" {{ old('role') == 'hr' ? 'selected' : '' }}>HR</option>
                        <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit"
                    style="padding:10px 24px;background:#6366f1;color:#fff;border:none;border-radius:10px;font-size:13.5px;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;">
                    <i class="bi bi-check-circle me-1"></i> Create User
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
