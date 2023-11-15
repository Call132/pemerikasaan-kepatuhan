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
            <a href="/">SISTERS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
    <a href="/"><img src="{{ asset('img/logo.png') }}" alt="Logo"></a>
</div>
        <ul class="sidebar-menu">
            <li class="menu-header fa">Dashboard</li>
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
                    <i class="fa-solid fa-file-pen"></i><span>Pelaksanaan Pemeriksaan</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link has-dropdown" style="line-height: 1;"><i class="fa-solid fa-file-lines"></i>
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
                        class="fa-solid fa-chart-simple"></i><span> Monitoring</span>
                </a>
            </li>
            <li class="nav-item ">
                <a href="{{ url('/arsip') }}" class="nav-link" style="line-height: 1;"><i
                        class="fa-solid fa-box-archive"></i><span>
                        Arsip</span>
                </a>
            </li>
        </ul>
    </aside>
</div>