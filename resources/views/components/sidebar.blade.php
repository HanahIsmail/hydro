<!-- component/sidebar -->
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}"><i class="fas fa-"></i>HydroNutrient</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">H</a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}"><i
                        class="fas fa-dashboard"></i><span>Dashboard</span></a>
            </li>

            @if (auth()->user()->roles == 'Pemilik')
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link {{ Request::is('users') ? 'active' : '' }}"><i
                            class="fas fa-users"></i><span>Data Pengelola</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('monthly.history') }}"
                        class="nav-link {{ Request::is('monthly-history') ? 'active' : '' }}"><i
                            class="fas fa-chart-bar"></i><span>Grafik Bulanan</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.index') }}" class="nav-link {{ Request::is('settings') ? 'active' : '' }}"><i
                            class="fas fa-cog"></i><span>Pengaturan TDS</span></a>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ route('tds.current') }}"
                        class="nav-link {{ Request::is('tds-current') ? 'active' : '' }}"><i
                            class="fas fa-tint"></i><span>Data TDS Sekarang</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hourly.history') }}"
                        class="nav-link {{ Request::is('hourly-history') ? 'active' : '' }}"><i
                            class="fas fa-chart-line"></i><span>Grafik Per Jam</span></a>
                </li>
            @endif
        </ul>
    </aside>
</div>
