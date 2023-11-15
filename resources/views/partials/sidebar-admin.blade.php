<!-- sidebar-admin.blade.php -->

<style>
    .nav-link {
        line-height: 1;
        margin-bottom: 10px;
    }
    .sidebar-brand-sm img {
        max-width: 100%;
        height: auto;
    }
</style>

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">SISTERS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
    <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('img/logo.png') }}" alt="Logo"></a>
</div>
        <ul class="sidebar-menu">
            <li class="menu-header fa">Dashboard</li>
            <li class="nav-item ">
                <a href="{{ route('manajemen-user') }}" class="nav-link" style="line-height: 1;"><i
                        class="fas fa-fire"></i><span>Manajemen Pengguna</span></a>
            </li>
            <li class="nav-item ">
                <a href="{{ route('manajemen-user') }}" class="nav-link" style="line-height: 1;"><i
                        class="fas fa-fire"></i><span>Monitoring</span></a>
            </li>
        </ul>
    </aside>
</div>
