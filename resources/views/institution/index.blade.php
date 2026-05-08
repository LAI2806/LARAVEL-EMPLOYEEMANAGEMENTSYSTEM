@extends('layouts.app')

@section('content')

{{-- Hero Banner --}}
<div style="border-radius:16px;overflow:hidden;margin-bottom:24px;position:relative;">
    <img src="{{ asset('images/akin.jpg') }}"
         style="width:100%;height:220px;object-fit:cover;display:block;">
    <div style="position:absolute;inset:0;background:linear-gradient(to bottom,rgba(15,23,42,0.4),rgba(15,23,42,0.78));display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:24px;">
        <div style="width:64px;height:64px;border-radius:16px;background:#6366f1;color:#fff;font-size:22px;font-weight:800;display:flex;align-items:center;justify-content:center;margin-bottom:14px;box-shadow:0 8px 24px rgba(99,102,241,0.4);"><img src="{{ asset('images/HAHAHA.png') }}" alt="Company Logo" style="width:100%;height:100%;border-radius:16px;"></div>
        <h2 style="color:#fff;font-size:24px;font-weight:800;margin:0 0 4px;text-shadow:0 2px 8px rgba(0,0,0,0.4);">Matina Tech IT Solutions</h2>
        <p style="color:rgba(255,255,255,0.7);font-size:13px;font-style:italic;margin:0;">"Innovating Technology for a Smarter Tomorrow."</p>
        <p style="color:rgba(255,255,255,0.5);font-size:12px;margin:6px 0 0;"><i class="bi bi-geo-alt-fill me-1"></i>Matina Aplaya, Davao City, Philippines · Est. 2024</p>
    </div>
</div>

{{-- Row 1: Overview + Company Info --}}
<div class="row g-3 mb-3">

    <div class="col-12 col-md-6">
        <div class="data-card h-100">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-building me-2" style="color:#6366f1;"></i>Company Overview</span>
            </div>
            <div style="padding:20px;font-size:13.5px;color:var(--text-muted);line-height:1.85;">
                <p style="margin-bottom:12px;">MATINA TECH IT SOLUTIONS is a modern technology company that provides reliable and innovative digital services for businesses, schools, and organizations. The company focuses on delivering efficient IT solutions, software development, and technical support.</p>
                <p style="margin:0;">Established with a vision of making technology more accessible and efficient, MATINA TECH IT SOLUTIONS aims to become one of the trusted IT service providers in the local community and nearby regions.</p>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="data-card h-100">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-info-circle me-2" style="color:#6366f1;"></i>Company Information</span>
            </div>
            <div style="padding:12px 20px;">
                @foreach([
                    ['Company Name',    'MATINA TECH IT SOLUTIONS'],
                    ['Business Type',   'Information Technology Services'],
                    ['Industry',        'Software & Technology'],
                    ['Founded',         '2024'],
                    ['Location',        'Matina Aplaya, Davao City, Philippines'],
                    ['Office Address',  'Phase 2, Matina Aplaya Road, Davao City, 8000'],
                ] as [$label, $value])
                <div style="display:flex;gap:12px;padding:9px 0;border-bottom:1px solid var(--border);font-size:13px;">
                    <div style="min-width:130px;font-weight:700;color:var(--text-muted);font-size:11px;text-transform:uppercase;letter-spacing:.4px;padding-top:2px;">{{ $label }}</div>
                    <div style="color:var(--text-primary);font-weight:500;">{{ $value }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

{{-- Row 2: Mission + Vision --}}
<div class="row g-3 mb-3">

    <div class="col-12 col-md-6">
        <div class="data-card h-100">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-bullseye me-2" style="color:#6366f1;"></i>Mission</span>
            </div>
            <div style="padding:20px;font-size:13.5px;color:var(--text-muted);line-height:1.85;">
                To provide innovative, secure, and affordable technology solutions that empower businesses and organizations to operate efficiently in the digital world.
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="data-card h-100">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-eye me-2" style="color:#6366f1;"></i>Vision</span>
            </div>
            <div style="padding:20px;font-size:13.5px;color:var(--text-muted);line-height:1.85;">
                To become a leading IT solutions provider recognized for excellence, innovation, and customer satisfaction in the Philippines.
            </div>
        </div>
    </div>

</div>

{{-- Row 3: Core Values --}}
<div class="data-card mb-3">
    <div class="data-card-header">
        <span class="data-card-title"><i class="bi bi-star me-2" style="color:#6366f1;"></i>Core Values</span>
    </div>
    <div style="padding:20px;">
        <div class="row g-3">
            @foreach([
                ['bi-lightbulb',    'Innovation',           'Encouraging creative and modern technology solutions.'],
                ['bi-shield-check', 'Integrity',            'Providing honest and professional services to clients.'],
                ['bi-trophy',       'Excellence',           'Delivering quality work and exceeding expectations.'],
                ['bi-people',       'Teamwork',             'Working collaboratively to achieve company goals.'],
                ['bi-heart',        'Customer Commitment',  'Prioritizing client satisfaction and long-term partnerships.'],
            ] as [$icon, $title, $desc])
            <div class="col-12 col-sm-6 col-lg-4">
                <div style="background:#f8fafc;border:1px solid var(--border);border-radius:12px;padding:16px 18px;height:100%;">
                    <div style="font-size:13px;font-weight:700;color:#6366f1;margin-bottom:6px;display:flex;align-items:center;gap:8px;">
                        <i class="bi {{ $icon }}"></i> {{ $title }}
                    </div>
                    <div style="font-size:12.5px;color:var(--text-muted);line-height:1.6;">{{ $desc }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Row 4: Objectives + Services --}}
<div class="row g-3 mb-3">

    <div class="col-12 col-md-6">
        <div class="data-card h-100">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-list-check me-2" style="color:#6366f1;"></i>Company Objectives</span>
            </div>
            <div style="padding:12px 20px;">
                @foreach([
                    'To deliver high-quality and reliable IT services to clients.',
                    'To develop modern software systems that improve business operations.',
                    'To provide fast and efficient technical support and maintenance services.',
                    'To promote digital transformation for local businesses and institutions.',
                    'To continuously innovate and adapt to emerging technologies.',
                    'To maintain strong relationships with clients through professionalism and trust.',
                ] as $i => $obj)
                <div style="display:flex;gap:14px;align-items:flex-start;padding:10px 0;border-bottom:1px solid var(--border);font-size:13.5px;color:#334155;">
                    <div style="width:26px;height:26px;border-radius:50%;background:#6366f1;color:#fff;font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">{{ $i + 1 }}</div>
                    <div style="padding-top:3px;">{{ $obj }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="data-card h-100">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-gear me-2" style="color:#6366f1;"></i>Services Offered</span>
            </div>
            <div style="padding:12px 20px;">
                @foreach([
                    'Custom Software Development',
                    'Web Design and Development',
                    'Mobile Application Development',
                    'IT Consulting Services',
                    'Technical Support and Maintenance',
                    'Database Management',
                    'Cloud Solutions',
                    'Network Setup and Configuration',
                    'Cybersecurity Assistance',
                    'Computer Troubleshooting and Repair',
                ] as $service)
                <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border);font-size:13.5px;color:var(--text-primary);font-weight:500;">
                    <div style="width:8px;height:8px;border-radius:50%;background:#6366f1;flex-shrink:0;"></div>
                    {{ $service }}
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

{{-- Row 5: Contact + Office Hours --}}
<div class="row g-3">

    <div class="col-12 col-md-6">
        <div class="data-card h-100">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-telephone me-2" style="color:#6366f1;"></i>Contact Information</span>
            </div>
            <div style="padding:20px;display:flex;flex-direction:column;gap:14px;">
                @foreach([
                    ['bi-geo-alt',   'Office Address',  'Phase 2, Matina Aplaya Road, Davao City, 8000 Philippines'],
                    ['bi-phone',     'Contact Number',  '+63 917 845 6210'],
                    ['bi-telephone', 'Telephone',       '(082) 295-1842'],
                    ['bi-envelope',  'Email Address',   'info@matinatechsolutions.com'],
                    ['bi-globe',     'Website',         'www.matinatechsolutions.com'],
                ] as [$icon, $label, $value])
                <div style="display:flex;gap:12px;align-items:flex-start;">
                    <div style="width:34px;height:34px;border-radius:8px;background:#f0f0fd;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi {{ $icon }}" style="color:#6366f1;font-size:15px;"></i>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);">{{ $label }}</div>
                        <div style="font-size:13px;color:var(--text-primary);margin-top:2px;font-weight:500;">{{ $value }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="data-card h-100">
            <div class="data-card-header">
                <span class="data-card-title"><i class="bi bi-clock me-2" style="color:#6366f1;"></i>Office Hours</span>
            </div>
            <div style="padding:12px 20px;">
                @foreach([
                    ['Monday – Friday', '8:00 AM – 6:00 PM', false],
                    ['Saturday',        '9:00 AM – 3:00 PM', false],
                    ['Sunday',          'Closed',             true],
                ] as [$day, $time, $closed])
                <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid var(--border);">
                    <div style="font-weight:600;font-size:13.5px;color:var(--text-primary);">
                        <i class="bi bi-calendar3 me-2" style="color:{{ $closed ? '#94a3b8' : '#6366f1' }};"></i>{{ $day }}
                    </div>
                    <div style="font-weight:700;font-size:13px;color:{{ $closed ? '#ef4444' : '#6366f1' }};">{{ $time }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection