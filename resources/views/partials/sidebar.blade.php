    <style>
    .nav-link {
        line-height: 1;
        margin-bottom: 10px;
    }

    .sidebar-brand-sm img {
        max-width: 100%;
        max-height: 30px;
        /* Sesuaikan dengan tinggi yang diinginkan */
        height: auto;
    }
</style>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            @if(Auth::check())
            @if(Auth::user()->hasRole('admin|user approval'))
            <a href="{{ url('/dashboard-admin') }}">SIS-RISKA</a>
            @else
            <a href="{{ url('/') }}">SIS-RISKA</a>
            @endif
            @else
            <a href="/">SIS-RISKA</a>
            @endif
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            @if(Auth::check())
            @if(Auth::user()->hasRole('admin|user approval'))
            <a href="{{ url('/dashboard-admin') }}"><img src="{{ asset('img/SIS-RISKA-fix.png') }}" alt="Logo"></a>
            @else
            <a href="{{ url('/') }}"><img src="{{ asset('img/SIS-RISKA-fix.png') }}" alt="Logo"></a>
            @endif
            @else
            <a href="/"><img src="{{ asset('img/SIS-RISKA-fix.png') }}" alt="Logo"></a>
            @endif
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header ">Dashboard</li>
            @if (Auth::user()->hasRole('admin|user approval'))
            <li class='{{ Request::is(' dashboard-admin') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ url('/dashboard-admin') }}"><i class="fas fa-tachometer"></i>Dashboard</a>
            </li>

            @endif


            <li class="nav-item dropdown">
                <a href="{{ url('/') }}" class="nav-link has-dropdown" style="line-height: 1;">
                    <i class="fas fa-tachometer-alt"></i><span>Perencanaan Pemeriksaan</span>
                </a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is(' perencanaan') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('perencanaan') }}">Buat Perencanaan</a>
                    </li>
                    <li class='{{ Request::is(' spt') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('/spt') }}">Surat Perintah Tugas</a>
                    </li>
                    <li class='{{ Request::is(' Pengiriman-surat') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('/pengiriman-surat') }}">Pengiriman Surat</a>
                    </li>
                    <li class='{{ Request::is(' program-pemeriksaan') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('/program-pemeriksaan') }}">Program Pemeriksaan</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item ">
                <a href="{{ url('/kertas-kerja') }}" class="nav-link" style="line-height: 1;">
                    <i class="fas fa-file-pen"></i><span>Pelaksanaan Pemeriksaan</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link has-dropdown" style="line-height: 1;"><i class="fas fa-file-lines"></i>
                    <span>Laporan Pemeriksaan</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is(' ') ? ' active' : '' }}'>
                        <a class="nav-link" href="{{ url('/lhps') }}">Laporan Hasil Pemeriksaan Sementara</a>
                    </li>
                    <li class='{{ Request::is(' ') ? ' active' : '' }}'>
                        <a class="nav-link" href="{{ url('/sphp') }}">Surat Pemberitahuan Hasil Pemeriksaan</a>
                    </li>
                    <li class='{{ Request::is(' ') ? ' active' : '' }}'>
                        <a class="nav-link" href="{{ url('/lhpa') }}">Laporan Hasil Pemeriksaan Akhir</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item ">
                <a href="{{ url('/monitoring') }}" class="nav-link" style="line-height: 1;"><i
                        class="fas fa-chart-simple"></i><span> Monitoring</span>
                </a>
            </li>
            <li class="nav-item ">
                <a href="{{ url('/arsip') }}" class="nav-link" style="line-height: 1;"><i
                        class="fas fa-box-archive"></i><span>
                        Arsip</span>
                </a>
            </li>
            @if (Auth::user()->hasRole('admin'))
            <li class="nav-item ">
                <a href="{{ route('manajemen-user') }}" class="nav-link" style="line-height: 1;"><i
                        class="fas fa-users-gear"></i><span>Manajemen Pengguna</span></a>
            </li>



            @endif
        </ul>
    </aside>
</div>