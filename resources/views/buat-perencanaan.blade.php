@extends('layout.main')

@section('main')
<div class="row">
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Buat Perencanaan Pemeriksaan</h1>

            </div>
        </section>
        <div class="container">
            <div class="card">

                <div class="card-body">


                    <p class="card-text">
                    <div class="col-md-100">
                        <div class="col-md-100">
                            @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
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

                                <form method="POST" action="{{ route('perencanaan.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="start_date">Tanggal Awal</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date">Tanggal Akhir</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_tim_pemeriksa">Nama Petugas Pemeriksa</label>
                                        <input type="text" name="nama_tim_pemeriksa" id="nama_tim_pemeriksa"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_kepala_bagian">Nama Kepala Bagian</label>
                                        <input type="text" name="nama_kepala_bagian" id="nama_kepala_bagian"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_kepala_cabang">Nama Kepala Cabang</label>
                                        <input type="text" name="nama_kepala_cabang" id="nama_kepala_cabang"
                                            class="form-control" required>
                                    </div>

                                    <!-- Tambahkan input lain sesuai kebutuhan -->
                                    <button type="submit" class="btn btn-primary">Buat Perencanaan</button>
                                </form>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endsection