<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HRIS') }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-accent: #6366f1;
            --main-bg: #f1f5f9;
            --card-bg: #ffffff;
            --text-primary: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --radius: 14px;
            --shadow: 0 2px 16px rgba(15,23,42,0.07);
            --sidebar-w: 240px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--main-bg);
            margin: 0;
        }

        /* ═══════════════════════════════════════════════
           LAYOUT
        ═══════════════════════════════════════════════ */
        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: sticky;
            top: 0;
            border-right: 1px solid #eeeff5;
            z-index: 1040;
            transition: transform .25s ease;
        }

        /* ── Main content ── */
        .main-content {
            flex: 1;
            min-width: 0; /* prevents flex child from overflowing */
            padding: 24px;
            overflow-x: hidden;
        }

        /* ── Overlay (mobile only) ── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,.45);
            z-index: 1039;
            backdrop-filter: blur(2px);
        }
        .sidebar-overlay.active { display: block; }

        /* ── Top mobile navbar ── */
        .mobile-topbar {
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background: #fff;
            border-bottom: 1px solid #eeeff5;
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .mobile-topbar .sb-logo {
            width: 30px; height: 30px; border-radius: 8px;
            background: #6366f1; color: #fff;
            font-size: 12px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .mobile-topbar .brand-name {
            font-size: 15px; font-weight: 700; color: #1a1a2e;
        }
        .hamburger {
            background: none; border: none; cursor: pointer;
            padding: 6px; border-radius: 8px; color: #6366f1;
            font-size: 22px; line-height: 1;
            display: flex; align-items: center; justify-content: center;
        }
        .hamburger:hover { background: #f0f0fd; }

        /* ═══════════════════════════════════════════════
           SIDEBAR INTERNALS
        ═══════════════════════════════════════════════ */
        .sb-brand {
            padding: 22px 20px 16px;
            display: flex; align-items: center; gap: 10px;
            border-bottom: 1px solid #f0f0f6;
        }
        .sb-logo {
            width: 34px; height: 34px; border-radius: 9px;
            background: #6366f1; color: #fff;
            font-size: 13px; font-weight: 700;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .sb-company { font-size: 15px; font-weight: 700; color: #1a1a2e; }
        .sb-tagline  { font-size: 11px; color: #a0a3b8; margin-top: 1px; }

        .sb-user {
            padding: 14px 20px;
            display: flex; align-items: center; gap: 12px;
            border-bottom: 1px solid #f0f0f6;
        }
        .sb-avatar {
            width: 40px; height: 40px; border-radius: 50%;
            background: #eeeeff; color: #6366f1;
            font-size: 13px; font-weight: 700;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
            overflow: hidden;
        }
        .sb-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .sb-uname { font-size: 13.5px; font-weight: 700; color: #1a1a2e; }
        .sb-role  { font-size: 11.5px; color: #a0a3b8; margin-top: 2px; }

        .sb-nav { flex: 1; overflow-y: auto; padding: 10px 12px; }

        .sb-section-label {
            font-size: 10px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .8px;
            color: #c8cad8; padding: 12px 12px 4px;
        }

        .sb-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 12px; border-radius: 10px;
            font-size: 13.5px; font-weight: 500; color: #7a7f9a;
            text-decoration: none; margin-bottom: 2px;
            position: relative; transition: background .15s, color .15s;
        }
        .sb-link i { font-size: 16px; opacity: .6; }
        .sb-link:hover { background: #f4f4fb; color: #6366f1; }
        .sb-link:hover i { opacity: 1; }
        .sb-link.active { background: #f0f0fd; color: #6366f1; font-weight: 600; }
        .sb-link.active i { opacity: 1; }
        .sb-link.active::after {
            content: '';
            position: absolute; right: 0; top: 20%; bottom: 20%;
            width: 3px; border-radius: 3px 0 0 3px;
            background: #6366f1;
        }

        .sb-footer {
            padding: 12px; border-top: 1px solid #f0f0f6;
            display: flex; gap: 8px;
        }
        .sb-btn {
            flex: 1; padding: 8px 0; border-radius: 9px;
            font-size: 12px; font-weight: 600; cursor: pointer;
            border: 1px solid #eaebf2; background: transparent;
            color: #7a7f9a; text-align: center; text-decoration: none;
            transition: all .15s; display: block; font-family: inherit;
        }
        .sb-btn:hover { background: #f4f4fb; color: #6366f1; border-color: #d4d4f5; }
        .sb-btn.danger { color: #ef4444; border-color: #fde8e8; }
        .sb-btn.danger:hover { background: #fff5f5; }

        /* ═══════════════════════════════════════════════
           SHARED COMPONENTS
        ═══════════════════════════════════════════════ */

        /* Stat cards */
        .stat-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 16px 18px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            transition: transform .2s, box-shadow .2s;
            height: 100%;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(15,23,42,0.11); }

        .stat-icon {
            width: 36px; height: 36px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; margin-bottom: 10px;
        }
        .stat-value {
            font-size: 22px; font-weight: 700;
            font-family: 'DM Mono', monospace;
            line-height: 1; margin-bottom: 4px;
        }
        .stat-label { font-size: 12px; color: var(--text-muted); font-weight: 500; }

        .icon-indigo { background: rgba(99,102,241,.12);  color: #6366f1; }
        .icon-green  { background: rgba(16,185,129,.12);  color: #10b981; }
        .icon-amber  { background: rgba(245,158,11,.12);  color: #f59e0b; }
        .icon-red    { background: rgba(239,68,68,.12);   color: #ef4444; }
        .icon-blue   { background: rgba(59,130,246,.12);  color: #3b82f6; }
        .icon-purple { background: rgba(168,85,247,.12);  color: #a855f7; }

        /* Data card */
        .data-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        .data-card-header {
            display: flex; align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            flex-wrap: wrap;
            gap: 10px;
        }
        .data-card-title { font-size: 15px; font-weight: 700; color: var(--text-primary); }

        /* Table */
        .hris-table { width: 100%; border-collapse: collapse; }
        .hris-table th {
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .7px;
            color: var(--text-muted);
            padding: 12px 22px; text-align: left;
            border-bottom: 1px solid var(--border);
            background: #f8fafc;
            white-space: nowrap;
        }
        .hris-table td {
            padding: 13px 22px; font-size: 13.5px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        .hris-table tr:last-child td { border-bottom: none; }
        .hris-table tbody tr:hover td { background: #f8fafc; }

        /* Status badges */
        .badge-status {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 10px; border-radius: 20px;
            font-size: 12px; font-weight: 600; white-space: nowrap;
        }
        .badge-status::before {
            content: ''; width: 6px; height: 6px;
            border-radius: 50%; flex-shrink: 0;
        }
        .badge-present  { background: rgba(16,185,129,.1);  color: #10b981; }
        .badge-present::before  { background: #10b981; }
        .badge-absent   { background: rgba(239,68,68,.1);   color: #ef4444; }
        .badge-absent::before   { background: #ef4444; }
        .badge-late     { background: rgba(245,158,11,.1);  color: #d97706; }
        .badge-late::before     { background: #f59e0b; }
        .badge-on-leave { background: rgba(99,102,241,.1);  color: #6366f1; }
        .badge-on-leave::before { background: #6366f1; }
        .badge-pending  { background: rgba(245,158,11,.1);  color: #d97706; }
        .badge-pending::before  { background: #f59e0b; }
        .badge-approved { background: rgba(16,185,129,.1);  color: #10b981; }
        .badge-approved::before { background: #10b981; }
        .badge-rejected { background: rgba(239,68,68,.1);   color: #ef4444; }
        .badge-rejected::before { background: #ef4444; }

        /* Employee avatar/info */
        .emp-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: var(--brand-accent); color: #fff;
            font-size: 12px; font-weight: 700;
            display: inline-flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .emp-info  { display: flex; align-items: center; gap: 10px; }
        .emp-name  { font-weight: 600; font-size: 13.5px; }
        .emp-pos   { font-size: 12px; color: var(--text-muted); }

        @media (max-width: 1023px) {
          
            .sidebar {
                position: fixed;
                top: 0; left: 0;
                height: 100vh;
                transform: translateX(-100%);
            }
            
            .sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 32px rgba(15,23,42,.18);
            }

            .mobile-topbar { display: flex; }

            .main-content {
                padding: 16px;
            }

            .layout {
                flex-direction: column;
            }
        }

        @media (max-width: 639px) {
            .main-content { padding: 12px; }

            .d-flex.justify-content-between,
            .d-flex.align-items-center.justify-content-between {
                flex-wrap: wrap;
                gap: 10px;
            }

            /* Form 2-column grids → single column */
            [style*="grid-template-columns:1fr 1fr"],
            [style*="grid-template-columns: 1fr 1fr"] {
                display: flex !important;
                flex-direction: column !important;
                gap: 14px !important;
            }

            /* data-card padding */
            [style*="padding:24px"] { padding: 14px !important; }
            [style*="padding:0 24px 24px"] { padding: 0 14px 14px !important; }

            /* data-card-header filter forms wrap */
            .data-card-header form {
                flex-wrap: wrap !important;
                gap: 8px !important;
                width: 100%;
            }
            .data-card-header form select,
            .data-card-header form input[type="date"] {
                flex: 1 1 140px;
                min-width: 0;
            }

            /* Table font/padding */
            .hris-table th,
            .hris-table td {
                padding: 10px 12px !important;
                font-size: 12.5px !important;
            }

            /* Stat card values */
            .stat-value { font-size: 18px; }

            /* Button rows wrap */
            [style*="display:flex;gap:10px"],
            [style*="display:flex;gap:8px"] {
                flex-wrap: wrap;
            }

            /* Employee profile banner stacks */
            .p-4.mb-4.rounded-3.d-flex {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 14px !important;
            }
            /* Show the hidden today-clock on mobile */
            .text-end.d-none.d-md-block {
                display: block !important;
                text-align: left !important;
            }

            /* Quick actions full width */
            .p-3.d-flex.flex-wrap.gap-2 > a {
                flex: 1 1 100%;
                justify-content: center;
            }

            /* Report tabs wrap */
            .report-tabs { flex-wrap: wrap; gap: 6px; }
            .rtab {
                flex: 1 1 auto;
                text-align: center;
                font-size: 12px !important;
                padding: 6px 10px !important;
            }

            /* Charts */
            canvas { max-height: 200px !important; }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="mobile-topbar">
    <div class="d-flex align-items-center gap-2">
        <div class="sb-logo">MT</div>
        <span class="brand-name">MatinaTech</span>
    </div>
    <div class="d-flex align-items-center gap-2">
        <button class="hamburger" id="sidebarToggle" aria-label="Open menu">
            <i class="bi bi-list"></i>
        </button>
    </div>
</div>

{{-- ── Overlay backdrop ── --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="layout">

    {{-- ══════════ SIDEBAR ══════════ --}}
    <div class="sidebar" id="sidebar">

        {{-- Brand --}}
        <div class="sb-brand">
            <div class="sb-logo">MT</div>
            <div>
                <div class="sb-company">MatinaTech</div>
                <div class="sb-tagline">Employee Management</div>
            </div>
        </div>

        {{-- User --}}
        @auth
        <div class="sb-user">
            <div class="sb-avatar">
                @if(Auth::user()->profile_photo_url)
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="avatar">
                @else
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(strrchr(Auth::user()->name, ' ') ?? '', 1, 1)) }}
                @endif
            </div>
            <div>
                <div class="sb-uname">{{ Auth::user()->name }}</div>
                <div class="sb-role">{{ ucfirst(Auth::user()->role ?? 'User') }}</div>
            </div>
        </div>
        @endauth

        {{-- Nav --}}
        <nav class="sb-nav">
            <a href="{{ route('dashboard') }}" class="sb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>

            @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'hr']))
                <div class="sb-section-label">Management</div>
                <a href="{{ route('employees.index') }}" class="sb-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Employees
                </a>
                <a href="{{ route('departments.index') }}" class="sb-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3"></i> Departments
                </a>
                <a href="{{ route('attendance.report') }}" class="sb-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> Attendance
                </a>
                <a href="{{ route('leave.index') }}" class="sb-link {{ request()->routeIs('leave.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i> Leave Requests
                </a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('users.index') }}" class="sb-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-person-gear"></i> Users
                    </a>
                @endif
                <div class="sb-section-label">Analytics</div>
                <a href="{{ route('reports.index') }}" class="sb-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line"></i> Reports
                </a>
            @endif

            @if(Auth::check() && Auth::user()->role === 'manager')
                <div class="sb-section-label">Management</div>
                <a href="{{ route('manager.department.show') }}" class="sb-link {{ request()->routeIs('manager.department.*') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3"></i> Department
                </a>
                <a href="{{ route('manager.employees.index') }}" class="sb-link {{ request()->routeIs('manager.employees.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Employees
                </a>
                <a href="{{ route('attendance.team') }}" class="sb-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> Attendance
                </a>
                <a href="{{ route('leave.index') }}" class="sb-link {{ request()->routeIs('leave.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i> Leave Requests
                </a>
                <div class="sb-section-label">Analytics</div>
                <a href="{{ route('reports.index') }}" class="sb-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line"></i> Reports
                </a>
            @endif

            @if(Auth::check() && Auth::user()->role === 'employee')
                <div class="sb-section-label">Management</div>
                <a href="{{ route('employee.profile') }}" class="sb-link {{ request()->routeIs('employee.profile') ? 'active' : '' }}">
                    <i class="bi bi-person"></i> Profile
                </a>
                <a href="{{ route('attendance.index') }}" class="sb-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> Attendance
                </a>
                <a href="{{ route('leave.index') }}" class="sb-link {{ request()->routeIs('leave.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i> Leave Requests
                </a>
                <div class="sb-section-label">Analytics</div>
                <a href="{{ route('reports.index') }}" class="sb-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line"></i> Reports
                </a>
            @endif
        </nav>

        {{-- Footer --}}
        <div class="sb-footer">
            <form method="GET" action="{{ route('profile.edit') }}" style="flex:1;display:flex;">
                <button type="submit" class="sb-btn" style="width:100%;">Profile</button>
            </form>
            <form method="POST" action="{{ route('logout') }}" style="flex:1;display:flex;">
                @csrf
                <button class="sb-btn danger" style="width:100%;">Logout</button>
            </form>
        </div>

    </div>{{-- /sidebar --}}

    {{-- ══════════ MAIN CONTENT ══════════ --}}
    <div class="main-content flex-fill">
        @yield('content')
    </div>

</div>{{-- /layout --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ── Hamburger sidebar toggle ──
    const toggle   = document.getElementById('sidebarToggle');
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // prevent background scroll
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    toggle.addEventListener('click', () => {
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
    });

    overlay.addEventListener('click', closeSidebar);

    // Close sidebar when a nav link is tapped on mobile
    sidebar.querySelectorAll('.sb-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 1024) closeSidebar();
        });
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) closeSidebar();
    });
</script>

@stack('scripts')
</body>
</html>