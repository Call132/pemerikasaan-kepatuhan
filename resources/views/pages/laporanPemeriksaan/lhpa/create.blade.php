@extends('layout.main')

@section('title', 'Form Laporan Hasil Pemeriksaan Sementara')

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Laporan Hasil Pemeriksaan Akhir {{ $badanUsaha->nama_badan_usaha }}</h1>
        </div>
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                {{ session('success') }}
            </div>
        </div>
        @elseif (session()->has('error'))
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                {{ session('error') }}
            </div>
        </div>
        @endif
    </section>
    <form action="{{ route('lhpa.store', $badanUsaha->id) }}" method="post">
        @csrf
        @php
        $jumlah_tunggakan = floatval($badanUsaha->jumlah_tunggakan);
        @endphp
        <input type="hidden" value="{{ $badanUsaha->id }}" name="bu_id">
        <input type="hidden" value="{{ $spt->id }}" name="spt_id">
        <div class="card col-12 mt-3">
            <div class="card-header">
                <h4>Identifikasi Tunggakan Iuran</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="jumlah_tunggakan" class="mb-md-0 w-100 mb-2 text-start">Jumlah Nominal Tunggakan
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input value="{{ $jumlah_tunggakan }}" type="number" name="jumlah_tunggakan"
                            id="jumlah_tunggakan" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="bulan_menunggak" class="mb-md-0 w-100 mb-2 text-start">Jumlah Bulan Menunggak
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input value="{{ $badanUsaha->jumlah_bulan_menunggak ?? '' }}" type="text" name="bulan_menunggak"
                            id="bulan_menunggak" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="jumlah_pekerja" class="mb-md-0 w-100 mb-2 text-start">Jumlah Pekerja
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input value="{{ $lhps->jumlah_pekerja ?? '' }}" type="text" name="jumlah_pekerja" id="jumlah_pekerja"
                            class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-12 mt-3">
            <div class="card-header">
                <h4>Identifikasi Rincian Tunggakan</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tmtLastYearBulan" id="tmtLastYearLabel" class=" control-label text-center">TMT
                                Desember
                                Tahun Sebelumnya</label>
                            <div class="form-group">
                                <label for="tmtLastYearBulan" class="col-md-4 control-label">Bulan Menunggak</label>
                                <div class="col-md-100">
                                    <input value="{{ $lhps->last_year_bulan ?? '' }}" id="tmtLastYearBulan" type="text"
                                        name="tmtLastYearBulan" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tmtLastYearNominal" class="col-md-4 control-label">Nominal Tunggakan</label>
                            <div class="col-md-100">
                                <input value="{{ $lhps->last_year_nominal ?? '' }}" id="tmtLastYearNominal" type="number"
                                    class="form-control" name="tmtLastYearNominal">
                                </input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tmtLastYearPembayaran" class="col-md-4 control-label">Nominal Pembayaran</label>
                            <div class="col-md-100">
                                <input id="tmtLastyearPembayaran" type="number" class="form-control"
                                    name="tmtLastyearPembayaran">
                                </input>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tmtLastYear" id="thisYear" class=" control-label text-center">TMT
                                Desember tahun Berjalan</label>
                            <div class="form-group">
                                <label for="thisYearBulan" class="col-md-4 control-label">Bulan Menunggak</label>
                                <div class="col-md-100">
                                    <input value="{{ $lhps->this_year_bulan ?? '' }}" type="text" name="thisYearBulan"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="thisYearNominal" class="col-md-4 control-label">Nominal Tunggakan</label>
                            <div class="col-md-100">
                                <input value="{{ $lhps->this_year_nominal ?? '' }}" id="thisYearNominal" type="number"
                                    class="form-control" name="thisYearNominal">
                                </input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="thisYearPembayaran" class="col-md-4 control-label">Nominal
                                Pembayaran</label>
                            <div class="col-md-100">
                                <input id="thisYearPembayaran" type="number" class="form-control"
                                    name="thisYearPembayaran">
                                </input>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="div">
                    <br>
                    <hr>
                    <br>
                </div>
                <div class="form-group">
                    <label>Tindak Lanjut Hasil Pemeriksaan</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tindak_lanjut" value="seluruhnya" required>
                        <label class="form-check-label">Dibayar Seluruhnya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tindak_lanjut" value="relaksasi" required>
                        <label class="form-check-label">Relaksasi</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tindak_lanjut" value="rekonsiliasi" required>
                        <label class="form-check-label">Rekonsiliasi</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tindak_lanjut" value="tidak_dibayarkan" required>
                        <label class="form-check-label">Tidak Dibayarkan</label>
                    </div>
                </div>
                <div class="div">
                    <br>
                    <hr>
                    <br>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="tanggal_bayar" class="mb-md-0 w-100 mb-2 text-start">
                            Tanggal Bayar
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="rekomendasi_pemeriksa" class="mb-md-0 w-100 mb-2 text-start">Rekomendasi
                            Pemeriksa
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="rekomendasi_pemeriksa" id="rekomendasi_pemeriksa" class="form-control"
                            required>
                    </div>
                </div>
            </div>
        </div>


        <div class="d-flex">
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div>
    </form>
</div>

@endsection
@push('scripts')
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

@endpush