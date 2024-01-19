@extends('layout.main')

@section('title', 'Surat Panggilan Pemeriksaan Lapangan')

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Surat Panggilan Pemeriksaan Lapangan</h1>
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
    <form action="{{ route('sppl.store') }}" method="POST">
        @csrf
        <div class="card col-12 mt-1">
            <div class="card-header">
                <h4>Data Surat Panggilan Pemeriksaan Lapangan</h4>
            </div>
            <div class="card-body">
                <input type="hidden" name="badan_usaha_id" value="{{ $badanUsaha->id }}">
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="nomor_sppl" class="mb-md-0 w-100 mb-2 text-start">Nomor Surat Panggilan Pemeriksaan
                            Lapangan :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="nomor_sppl" id="nomor_sppl" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="tanggal_surat" class="mb-md-0 w-100 mb-2 text-start">Tanggal Surat Panggilan
                            Pemeriksaan Lapangan :
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
                        <input type="date" value="{{ $badanUsaha->jadwal_pemeriksaan }}" name="hari_tanggal_pelaksanaan"
                            id="hari_tanggal_pelaksanaan" class="form-control" readonly>
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
                        <label for="nama" class="mb-md-0 w-100 mb-2 text-start">Nama Petugas Pemeriksa
                            :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="noHp" class="mb-md-0 w-100 mb-2 text-start">No HP Petugas Pemeriksa :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="noHp" id="noHp" class="form-control" required>
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