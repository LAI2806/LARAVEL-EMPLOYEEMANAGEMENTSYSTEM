@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="mb-4">
    <div class="d-flex align-items-center gap-2 mb-1">
        <a href="{{ route('employees.index') }}"
           style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#f4f4fb;color:#6366f1;border:1px solid #e0e0fb;text-decoration:none;">
            <i class="bi bi-arrow-left" style="font-size:13px;"></i>
        </a>
        <h4 class="fw-bold mb-0" style="color:var(--text-primary)">Create New Employee</h4>
    </div>
    <p class="mb-0" style="font-size:13px;color:var(--text-muted);margin-left:36px;">Fill in the details below to add a new employee.</p>
</div>

{{-- ALERTS --}}
@if($errors->any())
    <div class="mb-3 p-3" style="background:#fff5f5;border:1px solid #fde8e8;border-radius:10px;color:#ef4444;font-size:13px;">
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif
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

{{-- FORM CARD --}}
<div class="data-card">
    <div class="data-card-header">
        <span class="data-card-title">Employee Information</span>
    </div>
    <div class="p-3">
        <form method="POST" action="{{ route('employees.store') }}">
            @csrf

            {{-- Name row --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">First Name</label>
                    <input type="text" name="first_name" class="form-control form-control-sm"
                           value="{{ old('first_name') }}"
                           placeholder="e.g. Juan"
                           required
                           style="border-radius:9px;font-size:13.5px;">
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Last Name</label>
                    <input type="text" name="last_name" class="form-control form-control-sm"
                           value="{{ old('last_name') }}"
                           placeholder="e.g. dela Cruz"
                           required
                           style="border-radius:9px;font-size:13.5px;">
                </div>
            </div>

            {{-- Contact row --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Email</label>
                    <input type="email" name="email" class="form-control form-control-sm"
                           value="{{ old('email') }}"
                           placeholder="juan@matinatech.com"
                           required
                           style="border-radius:9px;font-size:13.5px;">
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Phone</label>
                    <input type="tel" name="phone" class="form-control form-control-sm"
                           value="{{ old('phone') }}"
                           placeholder="+63 9XX XXX XXXX"
                           style="border-radius:9px;font-size:13.5px;">
                </div>
            </div>

            {{-- Address --}}
<div class="mb-3">
    <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Address</label>
    <div class="row g-2">
        <div class="col-md-4">
            <input type="text" name="building" class="form-control form-control-sm"
                   value="{{ old('building') }}"
                   placeholder="Building / Unit No. / Subdivision"
                   style="border-radius:9px;font-size:13.5px;">
        </div>
        <div class="col-md-4">
            <input type="text" name="street" class="form-control form-control-sm"
                   value="{{ old('street') }}"
                   placeholder="House No. / Street"
                   style="border-radius:9px;font-size:13.5px;">
        </div>
        <div class="col-md-4">
            <input type="text" name="barangay" class="form-control form-control-sm"
                   value="{{ old('barangay') }}"
                   placeholder="Barangay"
                   style="border-radius:9px;font-size:13.5px;">
        </div>
        <div class="col-md-3">
            <input type="text" name="city" class="form-control form-control-sm"
                   value="{{ old('city') }}"
                   placeholder="City / Municipality"
                   style="border-radius:9px;font-size:13.5px;">
        </div>
        <div class="col-md-3">
            <input type="text" name="province" class="form-control form-control-sm"
                   value="{{ old('province') }}"
                   placeholder="Province"
                   style="border-radius:9px;font-size:13.5px;">
        </div>
        <div class="col-md-3">
            <input type="text" name="district" class="form-control form-control-sm"
                   value="{{ old('district') }}"
                   placeholder="District"
                   style="border-radius:9px;font-size:13.5px;">
        </div>
        <div class="col-md-3">
            <input type="text" name="postal_code" class="form-control form-control-sm"
                   value="{{ old('postal_code') }}"
                   placeholder="Postal Code"
                   style="border-radius:9px;font-size:13.5px;">
        </div>
    </div>
</div>

            {{-- Department + Position --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Department</label>
                    <select name="department_id" class="form-select form-select-sm" required
                            style="border-radius:9px;font-size:13.5px;">
                        <option value="">Select a Department</option>
                        @foreach($departments ?? [] as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Position</label>
                    <input type="text" name="position" class="form-control form-control-sm"
                           value="{{ old('position') }}"
                           placeholder="e.g. Software Engineer"
                           required
                           style="border-radius:9px;font-size:13.5px;">
                </div>
            </div>

            {{-- Hire date + Status --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Hire Date</label>
                    <input type="date" name="hire_date" class="form-control form-control-sm"
                           value="{{ old('hire_date') }}"
                           style="border-radius:9px;font-size:13.5px;">
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Employment Status</label>
                    <select name="employment_status" class="form-select form-select-sm"
                            style="border-radius:9px;font-size:13.5px;">
                        <option value="active"     {{ old('employment_status') == 'active'     ? 'selected' : '' }}>Active</option>
                        <option value="inactive"   {{ old('employment_status') == 'inactive'   ? 'selected' : '' }}>Inactive</option>
                        <option value="terminated" {{ old('employment_status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                    </select>
                </div>
            </div>

            {{-- Actions --}}
            <div class="d-flex justify-content-between align-items-center pt-3 mt-2" style="border-top:1px solid var(--border);">
                <a href="{{ route('employees.index') }}"
                style="padding:9px 18px;border-radius:10px;background:#f4f4fb;color:#6366f1;border:1px solid #e0e0fb;font-size:13.5px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                    <i class="bi bi-arrow-left" style="font-size:12px;"></i> Cancel
                </a>
                <button type="submit"
                        style="padding:9px 22px;border-radius:10px;background:#6366f1;color:#fff;border:none;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                    <i class="bi bi-plus-circle"></i> Create Employee
                </button>
            </div>

        </form>
    </div>
</div>

@endsection