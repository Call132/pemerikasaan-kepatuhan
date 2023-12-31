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
            <h1> Laporan Hasil Pemeriksaan Akhir {{ $badanUsaha->nama_badan_usaha }}</h1>
        </div>
    </section>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <p class="card-text">
                <div class="col-md-100">
                    <div class="col-md-100">
                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                                action="{{ route('lhpa.store', ['id' => $badanUsaha->id]) }}">
                                @csrf
                                @php
                                $jumlah_tunggakan = floatval($badanUsaha->jumlah_tunggakan);
                                @endphp
                                <div class="card-header">
                                    <h5>Identifikasi Tunggakan Iuran</h5>
                                </div>
                                <input type="hidden" value="{{ $badanUsaha->id }}" name="bu_id">
                                <input type="hidden" value="{{ $spt->id }}" name="spt_id">

                                <div class="form-group">
                                    <label for="jumlah tunggakan">Jumlah Nominal Tunggakan</label>
                                    <input class="form-control" type="number" name="jumlah_tunggakan"
                                        id="jumlah_tunggakan" value="{{ $jumlah_tunggakan }}">
                                </div>
                                <div class="form-group">
                                    <label for="jumlah bulan menunggak">Jumlah Bulan Menunggak</label>
                                    <input value="{{ $badanUsaha->jumlah_bulan_menunggak }}" class="form-control"
                                        type="text" name="bulan_menunggak" id="bulan_menunggak">
                                </div>
                                
                                <div class="form-group">
                                    <label for="jumlah Pekerja">Jumlah Pekerja Terdaftar</label>
                                    <input value="{{ $lhps->jumlah_pekerja }}" class="form-control" type="text"
                                        name="jumlah_pekerja" id="jumlah_pekerja">
                                </div>
                                <div class="card-header">
                                    <h5>Identifikasi Rincian Tunggakan</h5>
                                </div>

                                <label for="tmtLastYear" id="tmtLastYearLabel">TMT Desember tahun sebelumnya</label>
                                <div class="form-group">
                                    <label for="tmtLastYearBulan">Bulan Menunggak</label>
                                    <input value="{{ $lhps->last_year_bulan }}" type="text" name="tmtLastYearBulan"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="tmtLastYearNominal">Nominal Tunggakan</label>
                                    <input value="{{ $lhps->last_year_nominal }}" type="number"
                                        name="tmtLastYearNominal" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="tmtLastyearPembayaran">Nominal Pembayaran</label>
                                    <input type="number" class="form-control" name="tmtLastyearPembayaran"
                                        id="tmtLastyearPembayaran">
                                </div>

                                <label for="tmtLastYear" id="thisYear">TMT Desember tahun tahun sekarang</label>
                                <div class="form-group">
                                    <label for="tmtLastYearBulan">Bulan Menunggak</label>
                                    <input value="{{ $lhps->this_year_bulan }}" type="text" name="thisYearBulan"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="tmtLastYearNominal">Nominal Tunggakan</label>
                                    <input value="{{ $lhps->this_year_nominal }}" type="number" name="thisYearNominal"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="thisYearPembayaran">Nominal Pembayaran</label>
                                    <input type="text" name="thisYearPembayaran" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Tindak Lanjut Hasil Pemeriksaan</label><br>
                                    <div class="div">
                                        <label class="radio-label">
                                            <input type="radio" name="tindak_lanjut" value="seluruhnya" required>
                                            <span>Dibayar Seluruhnya</span>
                                        </label>
                                    </div>
                                    <div class="div">
                                        <label class="radio-label">
                                            <input type="radio" name="tindak_lanjut" value="relaksasi" required>
                                            <span>Relaksasi</span>
                                        </label>
                                    </div>
                                    <div class="div">
                                        <label class="radio-label">
                                            <input type="radio" name="tindak_lanjut" value="rekonsiliasi" required>
                                            <span>Rekonsiliasi</span>
                                        </label>
                                    </div>
                                    <div class="div">
                                        <label class="radio-label">
                                            <input type="radio" name="tindak_lanjut" value="tidak_dibayarkan" required>
                                            <span>Tidak Dibayarkan</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Tanggal Bayar</label>
                                    <input type="date" class="form-control" name="tanggal_bayar" required>
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
                window.location.href = '/lhpa';
            }, 3000); // Redirect after 1 second (adjust the delay as needed)
        });
    }
    </script>
    <script>
        // Mendapatkan tahun saat ini
    var tahunSaatIni = new Date().getFullYear();
    
    // Mengisi tahun sebelumnya
    var tahunSebelumnya = tahunSaatIni - 1;
    
    // Mendapatkan elemen label
    var label = document.getElementById("tmtLastYearLabel");
    
    // Mengubah teks label dengan tahun sebelumnya
    label.textContent = "TMT Desember " + tahunSebelumnya;
    </script>
    <script>
        // Mendapatkan tahun saat ini
    var tahunSaatIni = new Date().getFullYear();
    
    // Mendapatkan elemen label
    var label = document.getElementById("thisYear");
    
    // Mengubah teks label menjadi tahun saat ini
    label.textContent = "Tahun " + tahunSaatIni + " (sd. Bulan Pemeriksaan dilakukan)";
    </script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
    @endpush