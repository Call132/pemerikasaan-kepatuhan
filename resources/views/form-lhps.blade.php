@extends('layout.main')

@section('title', 'Laporan Hasil Pemeriksaan Sementara')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1> Laporan Hasil Pemeriksaan</h1>
        </div>
    </section>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <p class="card-text">
                <div class="col-md-100">
                    <div class="col-md-100">
                        @if (session('error'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                    </div>
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <form id="myForm" method="post"
                                action="{{ route('lhps.store', ['id' => $badanUsaha->id]) }}">
                                @csrf
                                @php
                                $jumlah_tunggakan = floatval($badanUsaha->jumlah_tunggakan);
                                @endphp
                                <div class="card-header text-center">
                                    <h5>Formulir Hasil Pemeriksaan Sementara {{ $badanUsaha->nama_badan_usaha }}</h5>
                                </div>

                                <input type="hidden" value="{{ $badanUsaha->id }}" name="bu_id">
                                <input type="hidden" value="{{ $spt->id }}" name="spt_id">

                                <div class="card-header">
                                    <h5>Temuan Hasil Pemeriksaan</h5>
                                </div>

                                <div class="form-group">
                                    <label for="jumlah tunggakan">Jumlah Nominal Tunggakan</label>
                                    <input class="form-control" type="number" name="jumlah_tunggakan"
                                        id="jumlah_tunggakan" value="{{ $jumlah_tunggakan }}">
                                </div>
                                <div class="form-group">
                                    <label for="jumlah bulan menunggak">Jumlah Bulan Menunggak</label>
                                    <input class="form-control" type="text" name="bulan_menunggak" id="bulan_menunggak">
                                </div>
                                <div class="form-group">
                                    <label for="jumlah Pekerja">Jumlah Pekerja Terdaftar</label>
                                    <input class="form-control" type="text" name="jumlah_pekerja" id="jumlah_pekerja">
                                </div>

                                <div class="form-group">
                                    <label for="tanggapan bu">Tanggapan Badan Usaha</label>
                                    <input type="text" name="tanggapan_bu" id="tanggapan_bu" class="form-control"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rekomendasi Pemeriksa">Rekomendasi Pemeriksa</label>
                                    <input type="text" name="rekomendasi_pemeriksa" id="rekomendasi_pemeriksa"
                                        class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary " onclick="submitForm()">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    <script>
        function submitForm() {
        document.getElementById('myForm').addEventListener('submit', function() {
            setTimeout(function() {
                window.location.href = '/lhps';
            }, 3000); // Redirect after 1 second (adjust the delay as needed)
        });
    }
    </script>


    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
    @endpush