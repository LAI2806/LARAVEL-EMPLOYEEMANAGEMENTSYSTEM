
<div class="sidebar">

        {{-- USER PROFILE --}}
        <div class="head">
            <img src="{{ Auth::user()->profile_photo_url ?? 'https://cdn-icons-png.flaticon.com/512/149/149071.png' }}" class="user-img">
            <div class="user-details">
                <p class="title">{{ Auth::user()->role ?? 'User' }}</p>
                <p class="name">{{ Auth::user()->name }}</p>
            </div>
        </div>

        {{-- NAVIGATION --}}
        <div class="nav">
            <div class="menu">
                <p class="title">Menu</p>

                <ul>
                    <li class="active">
                        <a href="{{ route('dashboard') }}">
                            <i class="ph ph-house"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li><a href="#"><i class="ph ph-users"></i><span>Employees</span></a></li>
                    <li><a href="#"><i class="ph ph-briefcase"></i><span>Departments</span></a></li>
                    <li><a href="#"><i class="ph ph-calendar"></i><span>Attendance</span></a></li>
                    <li><a href="#"><i class="ph ph-file-text"></i><span>Leave Requests</span></a></li>
                    <li><a href="#"><i class="ph ph-chart-bar"></i><span>Reports</span></a></li>
                </ul>
            </div>

        <div class="mt-auto">

            {{-- PROFILE DROPDOWN (BREEZE STYLE) --}}
            <div class="dropdown mb-2">
                <button class="btn btn-light w-100 dropdown-toggle text-start" type="button" data-bs-toggle="dropdown">
                    {{ Auth::user()->name }}
                </button>

                <ul class="dropdown-menu w-100">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            Profile
                        </a>
                    </li>
                </ul>
            </div>

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger w-100">
                    Logout
                </button>
            </form>

        </div>

    </div>

    @role('admin|hr')
<li><a href="{{ route('employees.index') }}">Employees</a></li>
@endrole

@role('manager')
<li><a href="{{ route('manager.employees') }}">My Department</a></li>
@endrole

@role('employee')
<li><a href="{{ route('employee.profile') }}">My Profile</a></li>
@endrole