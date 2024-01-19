@extends('layout.main')

@section('title', 'Surat Pemberitahuan Panggilan Final Pemeriksaan Kantor')

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Surat Pemberitahuan Panggilan Final Pemeriksaan Kantor</h1>
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
    <form action="{{ route('sppfpk.store') }}" method="POST">
        @csrf
        <div class="card col-12 mt-1">
            <div class="card-header">
                <h4>Data Surat Pemberitahuan Panggilan Final Pemeriksaan Kantor</h4>
            </div>
            <div class="card-body">
                <input type="hidden" name="badan_usaha_id" value="{{ $badanUsaha->id }}">
                <input type="hidden" name="sppk_id" value="{{ $sppk->id }}">
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="nomor_sppfpk" class="mb-md-0 w-100 mb-2 text-start">Nomor Surat Panggilan
                            Pemeriksaan
                            Final Kantor :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="nomor_sppfpk" id="nomor_sppfpk" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="tanggal_surat" class="mb-md-0 w-100 mb-2 text-start">Tanggal Surat Panggilan
                            Pemeriksaan Final Kantor :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="date" name="tanggal_surat" id="tanggal_surat" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="hari_tanggal_pelaksanaan" class="mb-md-0 w-100 mb-2 text-start">Hari/Tanggal
                            Pelaksanaan :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="date" name="hari_tanggal_pelaksanaan" id="hari_tanggal_pelaksanaan"
                            class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="waktu" class="mb-md-0 w-100 mb-2 text-start">Waktu :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="waktu" id="hari_tanggal_pelaksanaan" class="form-control"
                            timezone="Asia/Singapore" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-12 mt-1">
            <div class="card-header">
                <h4>Informasi Petugas Pemeriksa</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="petugas_pemeriksa_nama" class="mb-md-0 w-100 mb-2 text-start">Nama Petugas Pemeriksa
                            :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" value="{{ $timPemeriksa->nama }}" name="petugas_pemeriksa_nama"
                            id="petugas_pemeriksa_nama" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="petugas_pemeriksa_npp" class="mb-md-0 w-100 mb-2 text-start">NPP Petugas Pemeriksa :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" value="{{ $timPemeriksa->npp }}" name="petugas_pemeriksa_npp"
                            id="petugas_pemeriksa_npp" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-12 mt-1 pendamping">
            <div class="card-header">
                <h4>Informasi Pemberi Kerja</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="pemberi_kerja_nama" class="mb-md-0 w-100 mb-2 text-start">Nama Pemberi Kerja :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" value="{{ $badanUsaha->nama_badan_usaha }}" name="pemberi_kerja_nama"
                            id="pemberi_kerja_nama" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="kode_entitas" class="mb-md-0 w-100 mb-2 text-start">Kode Entitas :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" value="{{ $badanUsaha->kode_badan_usaha }}" name="kode_entitas"
                            id="kode_entitas" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="alamat" class="mb-md-0 w-100 mb-2 text-start">Alamat :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" value="{{ $badanUsaha->alamat }}" name="alamat" id="alamat"
                            class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex ">
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div>
    </form>
</div>

@endsection