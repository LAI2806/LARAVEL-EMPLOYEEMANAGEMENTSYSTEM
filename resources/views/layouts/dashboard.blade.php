<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS — @yield('page-title', 'Dashboard')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-w: 260px;
            --topbar-h: 64px;
            --brand-bg: #0f172a;
            --brand-accent: #6366f1;
            --brand-accent-light: #818cf8;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #fff;
            --sidebar-hover: rgba(99,102,241,0.12);
            --sidebar-active-bg: rgba(99,102,241,0.20);
            --main-bg: #f1f5f9;
            --card-bg: #ffffff;
            --text-primary: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --radius: 14px;
            --shadow: 0 2px 16px rgba(15,23,42,0.07);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--main-bg);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--brand-bg);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .brand-icon {
            width: 36px; height: 36px;
            background: var(--brand-accent);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: #fff;
            flex-shrink: 0;
        }

        .brand-name {
            font-weight: 700;
            font-size: 15px;
            color: #fff;
            letter-spacing: .3px;
        }

        .brand-sub {
            font-size: 11px;
            color: var(--sidebar-text);
            letter-spacing: .5px;
        }

        .sidebar-section {
            padding: 18px 12px 6px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            color: #475569;
            text-transform: uppercase;
        }

        .sidebar-nav { flex: 1; padding: 0 8px; overflow-y: auto; }

        .nav-item-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all .18s ease;
            margin-bottom: 2px;
        }

        .nav-item-link:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text-active);
        }

        .nav-item-link.active {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-text-active);
            border-left: 3px solid var(--brand-accent);
            padding-left: 11px;
        }

        .nav-item-link i { font-size: 16px; width: 20px; text-align: center; }

        .sidebar-footer {
            padding: 12px 8px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            background: rgba(255,255,255,0.04);
        }

        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--brand-accent);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #fff; font-size: 13px;
            flex-shrink: 0;
        }

        .user-name { font-size: 13px; font-weight: 600; color: #e2e8f0; line-height: 1.2; }
        .user-role { font-size: 11px; color: var(--sidebar-text); }

        /* ── Main content ── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            height: var(--topbar-h);
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .page-heading { font-size: 18px; font-weight: 700; color: var(--text-primary); }
        .page-sub { font-size: 12px; color: var(--text-muted); }

        .topbar-actions { display: flex; align-items: center; gap: 14px; }

        .topbar-btn {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: transparent;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
            transition: all .15s;
        }
        .topbar-btn:hover { background: var(--main-bg); color: var(--text-primary); }

        .page-content { padding: 28px; flex: 1; }

        /* ── Stat cards ── */
        .stat-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 22px 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(15,23,42,0.11); }

        .stat-icon {
            width: 46px; height: 46px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            margin-bottom: 14px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            font-family: 'DM Mono', monospace;
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-label { font-size: 13px; color: var(--text-muted); font-weight: 500; }

        .stat-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 20px;
            margin-top: 8px;
        }

        /* Icon bg helpers */
        .icon-indigo  { background: rgba(99,102,241,.12); color: #6366f1; }
        .icon-green   { background: rgba(16,185,129,.12); color: #10b981; }
        .icon-amber   { background: rgba(245,158,11,.12); color: #f59e0b; }
        .icon-red     { background: rgba(239,68,68,.12);  color: #ef4444; }
        .icon-blue    { background: rgba(59,130,246,.12); color: #3b82f6; }
        .icon-purple  { background: rgba(168,85,247,.12); color: #a855f7; }

        /* ── Data card ── */
        .data-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .data-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
        }

        .data-card-title { font-size: 15px; font-weight: 700; color: var(--text-primary); }
        .data-card-body { padding: 0; }

        /* ── Table ── */
        .hris-table { width: 100%; border-collapse: collapse; }
        .hris-table th {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .7px;
            color: var(--text-muted);
            padding: 12px 22px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            background: #f8fafc;
        }
        .hris-table td {
            padding: 13px 22px;
            font-size: 13.5px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        .hris-table tr:last-child td { border-bottom: none; }
        .hris-table tbody tr:hover td { background: #f8fafc; }

        /* ── Badges ── */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-status::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
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

        /* ── Avatar ── */
        .emp-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: var(--brand-accent);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .emp-info { display: flex; align-items: center; gap: 10px; }
        .emp-name { font-weight: 600; font-size: 13.5px; }
        .emp-pos  { font-size: 12px; color: var(--text-muted); }

        /* ── Responsive ── */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- ───────── Sidebar ───────── --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-people-fill"></i></div>
        <div>
            <div class="brand-name">HRIS Portal</div>
            <div class="brand-sub">HR MANAGEMENT</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-section">Main</div>

        <a href="{{ route('dashboard') }}"
           class="nav-item-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>

        @if(in_array(auth()->user()->role, ['admin', 'hr']))
            <div class="sidebar-section">HR</div>

            <a href="{{ route('employees.index') }}"
               class="nav-item-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                <i class="bi bi-person-lines-fill"></i> Employees
            </a>

            <a href="{{ route('departments.index') }}"
               class="nav-item-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                <i class="bi bi-diagram-3"></i> Departments
            </a>
        @endif

        @if(auth()->user()->role === 'admin')
            <div class="sidebar-section">Admin</div>
            <a href="#" class="nav-item-link">
                <i class="bi bi-people"></i> Users
            </a>
        @endif

        <div class="sidebar-section">Workspace</div>

        <a href="{{ route('attendance.index') }}"
           class="nav-item-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> Attendance
        </a>

        <a href="{{ route('leave.index') }}"
           class="nav-item-link {{ request()->routeIs('leave-requests.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Leave Requests
        </a>

        @if(in_array(auth()->user()->role, ['admin', 'hr']))
            <a href="{{ route('reports.index') }}"
               class="nav-item-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i> Reports
            </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div style="flex:1; min-width:0;">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="topbar-btn" title="Logout">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- ───────── Main ───────── --}}
<div class="main-wrapper">
    <header class="topbar">
        <div>
            <div class="page-heading">@yield('page-title', 'Dashboard')</div>
            <div class="page-sub">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</div>
        </div>
        <div class="topbar-actions">
            <button class="topbar-btn"><i class="bi bi-bell"></i></button>
            <button class="topbar-btn"><i class="bi bi-gear"></i></button>
        </div>
    </header>

    <main class="page-content">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>