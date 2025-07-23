@php
use Illuminate\Support\Facades\Auth;
@endphp

<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo">
                {{ config('app.name', 'MIS Dashboard') }}
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                <li class="nav-item active">
                    <a href="{{ route('admin.dashboard') }}">
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">Components</h4>
                </li>

                {{-- Admin only --}}
                @if (Auth::check() && Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a href="{{ route('departments.index') }}">
                        <p>Departments</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}">
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}">
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('staff.index') }}">
                        <p>Staff</p>
                    </a>
                </li>
                @endif

                {{-- Admin, handler, reporter --}}
                @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'handler' || Auth::user()->role == 'reporter'))
                
                <li class="nav-item">
                    <a href="{{ route('incidents.index') }}">
                        <p>incidents</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('incidents.unassigned') }}">
                        <p>Incidents Unassigned</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('mitigations.index') }}">
                        <p>Mitigations</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('monitoring.index') }}">
                        <p>Monitoring</p>
                    </a>
                </li>
                @endif

                {{-- handler --}}
                @if (Auth::check() && Auth::user()->role == 'handler')
                <li class="nav-item">
                    <a href="{{ route('incidents.index') }}">
                        <p>My Incidents</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('mitigations.index') }}">
                        <p>Mitigations</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('monitoring.index') }}">
                        <p>Monitoring</p>
                    </a>
                </li>
                @endif

            </ul>
        </div>
    </div>
</div>