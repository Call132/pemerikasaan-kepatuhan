<style>
    .nav-link {
        line-height: 1;
        margin-bottom: 10px;
    }
</style>
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
            <li class="nav-item dropdown">
                <a href="{{ url('/') }}" class="nav-link has-dropdown" style="line-height: 1;"><i
                        class="fas fa-fire"></i><span>Perencanaan Pemeriksaan</span></a>
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
                <a href="{{ url('/kertas-kerja') }}" class="nav-link" style="line-height: 1;"><i
                        class="fas fa-fire"></i><span>Pelaksanaan Pemeriksaan</span></a>

            </li>

            <li class="nav-item dropdown">
                <a class="nav-link has-dropdown" style="line-height: 1;"><i class="fas fa-fire"></i><span>Laporan
                        Pemeriksaan</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is(' ') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('') }}">Laporan Hasil Pemeriksaan Sementara</a>
                    </li>
                    <li class='{{ Request::is(' ') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('') }}">Surat Pemberitahuan Hasil Pemeriksaan</a>
                    </li>
                    <li class='{{ Request::is(' ') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('') }}">Laporan Hasil Pemeriksaan Akhir</a>
                    </li>
                </ul>
    </aside>
</div>