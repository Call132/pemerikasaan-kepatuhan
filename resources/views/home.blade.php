@extends('layout.main')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Admin</h4>
                            </div>
                            <div class="card-body">
                                6
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>News</h4>
                            </div>
                            <div class="card-body">
                                42
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Reports</h4>
                            </div>
                            <div class="card-body">
                                1,201
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Online Users</h4>
                            </div>
                            <div class="card-body">
                                47
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="row">
                
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Badan Usaha</h4>
                            <div class="card-header-action">
                                <a href="{{ url('/export-badan-usaha') }}" class="btn btn-primary">Export to Excel</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                @php
                                    $totalTunggakan = 0;
                                @endphp

                                @if($badanUsaha->count() > 0)
                                <table class="table-striped mb-0 table">
                                    <thead>
                                        <tr>
                                            <th colspan="10" style="font-weight: bold; font-size: 16px; text-align: center;">PERENCANAAN PEMERIKSAAN</th>
                                        </tr>
                                        <tr>
                                            <th colspan="10" style="font-weight: bold; font-size: 14px; text-align: center; ">Hari, Tanggal Bulan Tahun - Hari, Tanggal Bulan Tahun</th>
                                        </tr>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Badan Usaha</th>
                                            <th>Kode Badan Usaha</th>
                                            <th>Alamat</th>
                                            <th>Kota/Kab</th>
                                            <th>Jenis Ketidakpatuhan</th>
                                            <th>Tanggal Terakhir Bayar</th>
                                            <th>Jumlah Tunggakan</th>
                                            <th>Jenis Pemeriksaan</th>
                                            <th>Jadwal Pemeriksaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($badanUsaha as $data)
                                        
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->nama_badan_usaha }}</td>
                                            <td>{{ $data->kode_badan_usaha }}</td>
                                            <td>{{ $data->alamat }}</td>
                                            <td>{{ $data->kota_kab }}</td>
                                            <td>{{ $data->jenis_ketidakpatuhan }}</td>
                                            <td>{{ $data->tanggal_terakhir_bayar }}</td>
                                            <td>Rp{{ number_format(floatval(str_replace(['Rp ', '.', ','], '', $data->jumlah_tunggakan)), 2, ',', '.') }}</td>
                                            <td>{{ $data->jenis_pemeriksaan }}</td>
                                            <td>{{ $data->jadwal_pemeriksaan }}</td>
                                        </tr>
                                        @php
                                        // Menambahkan jumlah tunggakan ke total
                                            $totalTunggakan += floatval(str_replace(['Rp ', '.', ','], '', $data->jumlah_tunggakan));
                                        @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7" class="totall text-center">Total</td>
                                            <td colspan="3" class="text-center">Rp {{ number_format($totalTunggakan, 2, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                @else
                                <p>error</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
