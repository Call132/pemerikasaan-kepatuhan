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
            <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
            <a href="{{ url('/') }}" class="nav-link has-dropdown" style="line-height: 1;"><i class="fas fa-fire"></i><span>Perencanaan Pemeriksaan</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('perencanaan') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('perencanaan') }}">Buat Perencanaan</a>
                    </li>
                    <li class='{{ Request::is('spt') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('/spt') }}">Surat Perintah Tugas</a>
                    </li>
                    <li class='{{ Request::is('sppk') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('/sppk') }}">Surat Panggilan Pemeriksaan Kantor</a>
                    </li>
                    <li class='{{ Request::is('sppfpk') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('/sppfpk') }}">Surat Pemberitahuan Panggilan Final Pemeriksaan Kantor</a>
                    </li>
                    <li class='{{ Request::is('sppl') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('/sppl') }}">Surat Pemberitahuan Pemeriksaan Lapangan</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
                <a href="{{ url('/') }}" class="nav-link has-dropdown" style="line-height: 1;"><i class="fas fa-fire"></i><span>Pelaksanaan Pemeriksaan</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('perencanaan') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('perencanaan') }}">Kertas Kerja Pemeriksaan</a>
                    </li>
                    <li class='{{ Request::is('spt') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('/spt') }}" style="line-height: 1;">Formulir Catatan Hasil Pemeriksaan</a>
                    </li>
                    <li class='{{ Request::is('sppk') ? 'active' : '' }}'>
                        <a class="nav-link" style="line-height: 1;" href="{{ url('/sppk') }}">Berita Acara Pengambilan Keterangan</a>
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
            <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
                <a href="{{ url('/') }}" class="nav-link has-dropdown" style="line-height: 1;"><i class="fas fa-fire"></i><span>Laporan Monitoring</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('perencanaan') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('perencanaan') }}">Rekapan</a>
                    </li>
</ul>
    </aside>
</div>
