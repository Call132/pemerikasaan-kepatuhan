@extends('layout.main')

@section('title', 'Form BAPKET')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1> Pelaksanaan Pemeriksaan </h1>
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
                                action="{{ route('bapket.store', ['id' => $badanUsaha->id]) }}">
                                @csrf
                                <div class="card-header text-center">
                                    <h5>Formulir Catatan Hasil Pemeriksaan</h5>
                                </div>
                                @php
                                $jumlah_tunggakan = number_format(floatval($badanUsaha->jumlah_tunggakan), 2, ',', '.');
                                @endphp
                           
                                <input type="hidden" value="{{ $spt->id }}" name="spt_id">
                                <input type="hidden" value="{{ $badanUsaha->id }}" name="bu_id">
                                <div class="form-group">
                                    <label for="TimPemeriksa">Tim Pemeriksa</label>
                                    <input value="{{ $timPemeriksa->nama }}" class="form-control" type="text"
                                        name="timPemeriksa" id="timPemeriksa" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="timPemeriksaNpp">Tim Pemeriksa</label>
                                    <input value="{{ $timPemeriksa->npp }}" class="form-control" type="text"
                                        name="timPemeriksaNpp" id="timPemeriksaNpp" disabled>
                                </div>
                                <div class="card-header text-center text-black ">
                                    <h5>Informasi Pemberi Kerja</h5>
                                </div>
                                <div class="form-group">
                                    <label for="Nama">Nama</label>
                                    <input class="form-control" type="text" name="nama" id="nama" required>
                                </div>
                                <div class="form-group">
                                    <label for="Jabatan">Jabatan</label>
                                    <input class="form-control" type="text" name="jabatan" id="jabatan" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_bu">Nama Badan Usaha</label>
                                    <input value="{{ $badanUsaha->nama_badan_usaha }}" class="form-control" type="text"
                                        name="nama_bu" id="nama_bu" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="kode_bu">Kode Badan Usaha</label>
                                    <input value="{{ $badanUsaha->kode_badan_usaha }}" class="form-control" type="text"
                                        name="kode_bu" id="kode_bu" disabled>
                                </div>
                                <div class="card-header text-center">
                                    <h5>Berita Acara Pengambilan Keterangan</h5>
                                </div>
                                <div class="form-group">
                                    <label for="nomor">Nomor Bapket</label>
                                    <input type="text" class="form-control" name="no_bapket" id="no_bapket">
                                </div>

                                <div class="form-group">
                                    <label for="tunggakanIuran">Tunggakan Iuran</label>
                                    <input value="{{ $jumlah_tunggakan }}" class="form-control" type="text"
                                        name="tunggakanIuran" required id="tunggakanIuran" >
                                </div>
                                <div class="form-group">
                                    <label for="bulanMenunggak">Bulan Menunggak</label>
                                    <input value="{{ $badanUsaha->jumlah_bulan_menunggak }}" class="form-control" type="number" name="bulanMenunggak" required
                                        id="bulanMenunggak">
                                </div>
                                <div class="form-group">
                                    <label for="sebabMenunggak">Sebab Menunggak</label>
                                    <input class="form-control" type="text" name="sebabMenunggak" required
                                        id="sebabMenunggak">
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
                window.location.href = '/kertas-kerja';
            }, 3000); // Redirect after 1 second (adjust the delay as needed)
        });
    }
    </script>


    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
    @endpush