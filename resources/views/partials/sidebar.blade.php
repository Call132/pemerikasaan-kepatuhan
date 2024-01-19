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
            @if(Auth::user()->role == 'Admin')
            <a href="{{ url('/') }}">SIS-RISKA</a>
            @else
            <a href="{{ url('/') }}">SIS-RISKA</a>
            @endif
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            @if(Auth::user()->role == 'Admin')
            <a href="{{ url('/') }}"><img src="{{ asset('img/SIS-RISKA-fix.png') }}" alt="Logo"></a>
            @else
            <a href="{{ url('/') }}"><img src="{{ asset('img/SIS-RISKA-fix.png') }}" alt="Logo"></a>
            @endif
        </div>
        @if (Auth::user()->role == 'Admin')
        <ul class="sidebar-menu">
            <li class="menu-header ">Dashboard</li>
            <li class="nav">
                <a href="{{ url('/') }}" class="nav-link" style="line-height: 1;">
                    <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                </a>
            </li>
            @endif
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" style="line-height: 1;">
                    <i class="fas fa-tachometer-alt"></i><span>Perencanaan Pemeriksaan</span>
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
            <li class="nav-item ">
                <a href="{{ url('/pelaksanaan-pemeriksaan') }}" class="nav-link" style="line-height: 1;">
                    <i class="fas fa-file-pen"></i><span>Pelaksanaan Pemeriksaan</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link has-dropdown" style="line-height: 1;"><i class="fas fa-file-lines"></i>
                    <span>Laporan Pemeriksaan</span></a>
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
            @if (Auth::user()->role == 'Admin')
            <li class="nav-item ">
                <a href="{{ route('manajemen-user') }}" class="nav-link" style="line-height: 1;"><i
                        class="fas fa-users-gear"></i><span>Manajemen Pengguna</span></a>
            </li>



            @endif
        </ul>
    </aside>
</div>