@extends('layouts.app')


@section('content')
<style>
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px; }
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px; }
    .info-actions { display:flex; gap:10px; }
    .info-grid { padding:24px; display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    @media(max-width:640px){
        .info-grid { grid-template-columns:1fr; }
    }
    @media(max-width:640px){
        .info-grid { grid-template-columns:1fr; }
        .form-actions { flex-direction:column; }
        .form-actions button, .form-actions a { width:100%; text-align:center; box-sizing:border-box; }
    }
</style>

<div class="mb-4">
    <h4 style="font-size:20px;font-weight:700;color:var(--text-primary);margin:0;">User Details</h4>
    <p style="font-size:13px;color:var(--text-muted);margin:4px 0 0;">Viewing account information.</p>
</div>

<div class="data-card">
    <div class="data-card-header">
        <div style="display:flex;align-items:center;gap:12px;">
            <div class="emp-avatar" style="width:42px;height:42px;font-size:15px;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-size:15px;font-weight:700;color:var(--text-primary);">{{ $user->name }}</div>
                <div style="font-size:12px;color:var(--text-muted);">{{ $user->email }}</div>
            </div>
        </div>
        <span class="badge-status {{ $user->role === 'hr' ? 'badge-approved' : 'badge-pending' }}">
            {{ ucfirst($user->role) }}
        </span>
    </div>

    <div class="info-grid">
        <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;border:1px solid var(--border);">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Full Name</div>
            <div style="font-size:14px;font-weight:600;color:var(--text-primary);">{{ $user->name }}</div>
        </div>
        <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;border:1px solid var(--border);">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Email</div>
            <div style="font-size:14px;font-weight:600;color:var(--text-primary);">{{ $user->email }}</div>
        </div>
        <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;border:1px solid var(--border);">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Role</div>
            <div style="font-size:14px;font-weight:600;color:var(--text-primary);">{{ ucfirst($user->role) }}</div>
        </div>
        <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;border:1px solid var(--border);">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);margin-bottom:6px;">Member Since</div>
            <div style="font-size:14px;font-weight:600;color:var(--text-primary);font-family:'DM Mono',monospace;">{{ $user->created_at->format('Y-m-d') }}</div>
        </div>
    </div>

    <div style="padding:0 24px 24px;display:flex;gap:10px;">
        <a href="{{ route('users.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;background:#fff;color:var(--text-muted);border:1px solid var(--border);border-radius:10px;font-size:13.5px;font-weight:600;text-decoration:none;">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <a href="{{ route('users.edit', $user->id) }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;background:rgba(99,102,241,.08);color:#6366f1;border:1px solid rgba(99,102,241,.3);border-radius:10px;font-size:13.5px;font-weight:600;text-decoration:none;">
            <i class="bi bi-pencil-square"></i> Edit
        </a>
    </div>
</div>

@endsection