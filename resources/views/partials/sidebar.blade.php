<style>
    .nav-link {
        line-height: 1;
        margin-bottom: 10px;
    }

    .sidebar-brand-sm img {
        max-width: 100%;
        max-height: 30px;
        height: auto;
    }
</style>

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">SIS-RISKA</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">
                <img src="{{ asset('img/SIS-RISKA-fix.png') }}" alt="Logo">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav">
                <a href="{{ url('/') }}" class="nav-link">
                    <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                </a>
            </li>
            @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'User Entry')
            <li class="menu-header">Pemeriksaan</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-search"></i><span>Perencanaan Pemeriksaan</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ url('/perencanaan') }}">Buat Perencanaan</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ url('/spt') }}">Surat Perintah Tugas</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ url('/pengiriman-surat') }}">Pengiriman Surat</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ url('/program-pemeriksaan') }}">Program Pemeriksaan</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ url('/pelaksanaan-pemeriksaan') }}" class="nav-link">
                    <i class="fas fa-file-alt"></i><span>Pelaksanaan Pemeriksaan</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link has-dropdown">
                    <i class="fas fa-clipboard-check"></i><span>Laporan Pemeriksaan</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ url('/lhps') }}">Laporan Hasil Pemeriksaan Sementara</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ url('/sphp') }}">Surat Pemberitahuan Hasil Pemeriksaan</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ url('/lhpa') }}">Laporan Hasil Pemeriksaan Akhir</a>
                    </li>
                </ul>
            </li>
            @endif
            <li class="menu-header">Monitoring</li>
            <li class="nav-item">
                <a href="{{ url('/monitoring') }}" class="nav-link">
                    <i class="fas fa-chart-line"></i><span> Monitoring</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/arsip') }}" class="nav-link">
                    <i class="fas fa-archive"></i><span> Arsip</span>
                </a>
            </li>
            @if (Auth::user()->role == 'Admin')
            <li class="menu-header">Setting</li>
            <li class="nav-item">
                <a href="{{ url('/user') }}" class="nav-link">
                    <i class="fas fa-cogs"></i><span>Manajemen Pengguna</span>
                </a>
            </li>
            @endif
        </ul>
    </aside>
</div>
