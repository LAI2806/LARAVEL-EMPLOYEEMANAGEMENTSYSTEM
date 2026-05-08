@extends('layouts.app')

@section('content')

<div class="mb-4">
    <div class="d-flex align-items-center gap-2 mb-1">
        <a href="{{ route('departments.index') }}"
           style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#f4f4fb;color:#6366f1;border:1px solid #e0e0fb;text-decoration:none;">
            <i class="bi bi-arrow-left" style="font-size:13px;"></i>
        </a>
        <h4 class="fw-bold mb-0" style="color:var(--text-primary)">Add Department</h4>
    </div>
    <p class="mb-0" style="font-size:13px;color:var(--text-muted);margin-left:36px;">Fill in the details below to create a new department.</p>
</div>

@if($errors->any())
    <div class="mb-3 p-3" style="background:#fff5f5;border:1px solid #fde8e8;border-radius:10px;color:#ef4444;font-size:13px;">
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="data-card">
    <div class="data-card-header">
        <span class="data-card-title">Department Information</span>
    </div>
    <div class="p-3">
        <form action="{{ route('departments.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Department Name *</label>
                <input type="text" name="name" class="form-control form-control-sm"
                       value="{{ old('name') }}"
                       placeholder="e.g. Engineering"
                       required
                       style="border-radius:9px;font-size:13.5px;">
            </div>

            <div class="mb-3">
                <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Manager</label>
                <select name="manager_id" class="form-select form-select-sm" style="border-radius:9px;font-size:13.5px;">
                    <option value="">Select Manager</option>
                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                            {{ $manager->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Description</label>
                <textarea name="description" rows="3" class="form-control form-control-sm"
                          placeholder="Brief description of this department's responsibilities…"
                          style="border-radius:9px;font-size:13.5px;resize:none;">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Status</label>
                <select name="status" class="form-select form-select-sm" style="border-radius:9px;font-size:13.5px;">
                    <option value="active"   {{ old('status') == 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-3 mt-1" style="border-top:1px solid var(--border);">
                <a href="{{ route('departments.index') }}"
                   style="padding:9px 18px;border-radius:10px;background:#f4f4fb;color:#6366f1;border:1px solid #e0e0fb;font-size:13.5px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                    <i class="bi bi-arrow-left" style="font-size:12px;"></i> Cancel
                </a>
                <button type="submit"
                        style="padding:9px 22px;border-radius:10px;background:#6366f1;color:#fff;border:none;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                    <i class="bi bi-plus-circle"></i> Create Department
                </button>
            </div>

        </form>
    </div>
</div>

@endsection