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
                <a href="{{ url('/') }}"
                class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Perencanaan Pemeriksaan</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('data-pemeriksaan') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('/') }}">Daftar Badan Usaha</a>
                    </li>
                    <li class='{{ Request::is('data-pemeriksaan') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('data-pemeriksaan') }}">Tambah Data BU</a>
                    </li>
                </ul>
            
            </li>
            <li class="nav-item {{ $type_menu === 'spt' ? 'active' : '' }}">
                <a href="{{ url('/spt') }}"
                    class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Surat Perintah Tugas</span></a>
                    <ul class="dropdown-menu">
                        <li class='{{ Request::is('spt') ? 'active' : '' }}'>
                            <a class="nav-link"
                                href="{{ url('/spt') }}">Buat SPT</a>
                        </li>
                        <li class='{{ Request::is('spt-preview') ? 'active' : '' }}'>
                            <a class="nav-link"
                                href="{{ url('/spt/preview') }}">preview</a>
                        </li>
                    </ul>
            </li>
            <li class="nav-item {{ $type_menu === 'spt' ? 'active' : '' }}">
                <a href="{{ url('/spt') }}"
                    class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Pengiriman Surat</span></a>
                    <ul class="dropdown-menu">
                        <li class='{{ Request::is('sppk') ? 'active' : '' }}'>
                            <a class="nav-link"
                                href="{{ url('/sppk') }}">Buat SPPK</a>
                        </li>
                        <li class='{{ Request::is('sppfpk') ? 'active' : '' }}'>
                            <a class="nav-link"
                                href="{{ url('/sppfpk') }}">Buat SPPFPK</a>
                        </li>
                        <li class='{{ Request::is('sppl') ? 'active' : '' }}'>
                            <a class="nav-link"
                                href="{{ url('/sppl') }}">Buat SPPL</a>
                        </li>
                    </ul>
            </li>
    </aside>
</div>
