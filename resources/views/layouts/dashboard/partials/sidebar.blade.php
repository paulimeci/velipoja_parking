<div class="sidebar-area" id="sidebar-area">
    <div class="logo position-relative">
        <a href="#" class="d-block text-decoration-none position-relative">
            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="logo-icon">
            <span class="logo-text fw-bold text-dark">Trezo</span>
        </a>
        <button class="sidebar-burger-menu bg-transparent p-0 border-0 opacity-0 z-n1 position-absolute top-50 end-0 translate-middle-y" id="sidebar-burger-menu">
            <i data-feather="x"></i>
        </button>
    </div>

    <aside id="layout-menu" class="layout-menu menu-vertical menu active" data-simplebar>
        <ul class="menu-inner">
            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">MAIN</span>
            </li>

            <li class="menu-item">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <span class="material-symbols-outlined menu-icon">dashboard</span>
                    <span class="title">Dashboard</span>
                </a>
            </li>

            @can('admin.dashboard')
            <li class="menu-item">
                <a href="{{ route('admin.dashboard') }}" class="menu-link">
                    <span class="material-symbols-outlined menu-icon">admin_panel_settings</span>
                    <span class="title">Admin Dashboard</span>
                </a>
            </li>
            @endcan


            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">APPS</span>
            </li>

            @can('operatori.kryej-operacionet')
            <li class="menu-item">
                <a href="{{ route('operatori.operacionet') }}" class="menu-link">
                    <span class="material-symbols-outlined menu-icon">rocket_launch</span>
                    <span class="title">Kryej Operacionet</span>
                </a>
            </li>
            @endcan



            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">settings</span>
                    <span class="title">Konfigurimet</span>
                </a>
                <ul class="menu-sub">
                    @can('admin.konfiguro-oret')
                        <li class="menu-item"><a href="{{ route('admin.manage.oret') }}" class="menu-link">Konfiguro oret</a></li>
                    @endcan
                    @can('admin.manage-users')
                        <li class="menu-item"><a href="{{ route('admin.users') }}" class="menu-link">Përdoruesit</a></li>
                    @endcan
                    @can('admin.manage-roles')
                        <li class="menu-item"><a href="{{ route('admin.roles') }}" class="menu-link">Rolet & Permissionet</a></li>
                    @endcan
                    <li class="menu-item"><a href="#" class="menu-link">Change Password</a></li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="#" class="menu-link" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                    <span class="material-symbols-outlined menu-icon">logout</span>
                    <span class="title">Logout</span>
                </a>
                <form id="sidebar-logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </aside>
</div>
