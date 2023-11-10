@extends('layout.main')

@section('title', 'Laporan Monitoring')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">

@endpush

@section('main')
<div class="row">
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Monitoring</h1>
            </div>
        </section>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    @php
                    $totalTunggakan = 0;
                    $totalBayar = 0;
                    @endphp
                    <table class="table table-striped-columns mb-0 ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pemeriksaan</th>
                                <th>Nama Badan Usaha</th>
                                <th>Kode Badan Usaha</th>
                                <th>Alamat</th>
                                <th>Tanggal Terakhir Bayar</th>
                                <th>Jumlah Bulan Menunggak</th>
                                <th>Jumlah Tunggakan</th>
                                <th>Tanggal Bayar</th>
                                <th>Jumlah Bayar</th>
                                <th>Hasil Pemeriksaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($badanUsaha as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->jadwal_pemeriksaan }}</td>
                                <td>{{ $data->nama_badan_usaha }}</td>
                                <td>{{ $data->kode_badan_usaha }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td>{{ $data->tanggal_terakhir_bayar }}</td>
                                <td>{{ $data->jumlah_bulan_menunggak }} (Bulan)</td>
                                <td>Rp.{{ number_format($data->jumlah_tunggakan, 2, ',', '.') }}</td>
                                <td>{{ $data->tanggal_bayar }}</td>
                                <td>Rp.{{ number_format($data->jumlah_bayar), 2, ',', '.' }}</td>
                                <td>hasil</td>
                            </tr>
                            @php
                            // Menambahkan jumlah tunggakan ke total
                            $totalTunggakan += $data->jumlah_tunggakan;
                            $totalBayar += $data->jumlah_bayar;
                            @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="totall">
                                <td colspan="7" class="totall text-center">Total</td>
                                <td colspan="2">
                                    Rp. {{ number_format($totalTunggakan, 2, ',', '.') }}
                                </td>
                                <td colspan="2">
                                    Rp. {{ number_format($totalBayar, 2, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection

@push('scripts')
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
@endpush