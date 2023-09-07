<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">Hmmm</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">Yaa</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
                <a href="/"
                    class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('dashboard') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('/') }}">Perencanaan Pemeriksaan</a>
                    </li>
                    <li class='{{ Request::is('create-data-pemeriksaan') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('create-data-pemeriksaan') }}">Tambah Data BU</a>
                    </li>
                </ul>
            </li>

    </aside>
</div>
