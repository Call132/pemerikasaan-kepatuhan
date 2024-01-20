@extends('layout.main')

@section('title', 'Surat Pemberitahuan Hasil Pemeriksaan')

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Surat Pemberitahuan Hasil Pemeriksaan</h1>
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
    <form action="{{ route('sphp.store', $badanUsaha->id) }}" method="post">
        @csrf
        <input type="hidden" value="{{ $badanUsaha->id }}" name="badan_usaha_id">
        <div class="card col-12 mt-3">
            <div class="card-header">
                <h4>Surat Pemberitahuan Hasil Pemeriksaan</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="no_sphp" class="mb-md-0 w-100 mb-2 text-start">Nomor Surat Pemberitahuan Hasil
                            Pemeriksaan:
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="no_sphp" id="no_sphp" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="tgl_sphp" class="mb-md-0 w-100 mb-2 text-start">Tanggal Surat Pemberitauhan Hasil
                            Pemeriksaan:
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="date" name="tgl_sphp" id="tgl_sphp" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-12 mt-3">
            <div class="card-header">
                <h4>Uraian Hasil</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="p-a" class="mb-md-0 w-100 mb-2 text-start">Point a.</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <textarea class="form-control" name="p-a" id="p-a"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="p-b" class="mb-md-0 w-100 mb-2 text-start">Point b.</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <textarea class="form-control" name="p-b" id="p-b"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="p-c" class="mb-md-0 w-100 mb-2 text-start">Point c.</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <textarea class="form-control" name="p-c" id="p-c"></textarea>
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