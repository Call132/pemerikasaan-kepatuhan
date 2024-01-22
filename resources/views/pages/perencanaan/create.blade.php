@extends('layout.main')

@section('title', 'Perencanaan Pemeriksaan')

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Perencanaan Pemeriksaan</h1>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card col-12 mt-3">
                    <div class="card-header">
                        <h4>Form Perencanaan Pemeriksaan</h4>
                    </div>
                    <form method="POST" action="{{ route('perencanaan.store') }}">
                        @csrf
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12 col-md-3">
                                    <label for="start_date" class="mb-md-0 w-100 mb-2 text-start">Tanggal Awal :
                                    </label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-3">
                                    <label for="end_date" class="mb-md-0 w-100 mb-2 text-start">Tanggal Akhir :
                                    </label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-3">
                                    <label for="nama_tim_pemeriksa" class="mb-md-0 w-100 mb-2 text-start">Nama Petugas
                                        Pemeriksa :
                                    </label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" name="nama_tim_pemeriksa" id="nama_tim_pemeriksa"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-3">
                                    <label for="nama_kepala_bagian" class="mb-md-0 w-100 mb-2 text-start">Nama
                                        Kepala Bagian :
                                    </label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" name="nama_kepala_bagian" id="nama_kepala_bagian"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-3">
                                    <label for="nama_kepala_cabang" class="mb-md-0 w-100 mb-2 text-start">Nama
                                        Kepala Cabang :
                                    </label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" name="nama_kepala_cabang" id="nama_kepala_cabang"
                                        class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection