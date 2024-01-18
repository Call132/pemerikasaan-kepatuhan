@extends('layout.main')

@section('title', 'Tambah Badan Usaha')

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Tambah Data Badan Usaha</h1>
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
    <form action="{{ route('badanusaha.store', $perencanaan->id) }}" method="post">
        @csrf
        <input type="hidden" name="perencanaan_id" value="{{ $perencanaan->id }}">
        <div class="card col-12 mt-3">
            <div class="card-header">
                <h4>Data Badan Usaha</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="nama_badan_usaha" class="col-md-4 control-label">Nama Badan
                                    Usaha</label>
                                <div class="col-md-100">
                                    <input id="nama_badan_usaha" type="text" class="form-control"
                                        name="nama_badan_usaha" required autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kode_badan_usaha" class="col-md-4 control-label">Kode Badan
                                Usaha</label>
                            <div class="col-md-50">
                                <input id="kode_badan_usaha" type="text" class="form-control" name="kode_badan_usaha"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alamat" class="col-md-4 control-label">Alamat</label>
                            <div class="col-md-100">
                                <textarea id="alamat" class="form-control" name="alamat" required></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="kota_kab" class="col-md-4 control-label">Kota/Kab</label>
                            <div class="col-md-100">
                                <input id="kota_kab" type="text" class="form-control" name="kota_kab" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jenis_ketidakpatuhan" class="col-md-4 control-label">Jenis
                                Ketidakpatuhan</label>
                            <div class="col-md-100">
                                <input id="jenis_ketidakpatuhan" type="text" class="form-control"
                                    name="jenis_ketidakpatuhan" required>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_terakhir_bayar" class="col-md-4 control-label">Tanggal
                                Terakhir Bayar</label>
                            <div class="col-md-100">
                                <input id="tanggal_terakhir_bayar" type="date" class="form-control"
                                    name="tanggal_terakhir_bayar" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jumlah_tunggakan" class="col-md-4 control-label">Jumlah
                                Tunggakan</label>
                            <div class="col-md-100">
                                <input id="jumlah_tunggakan" type="number" class="form-control" name="jumlah_tunggakan"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jenis_pemeriksaan" class="col-md-4 control-label">Jenis
                                Pemeriksaan</label>
                            <div class="col-md-100">
                                <select id="jenis_pemeriksaan" class="form-control" name="jenis_pemeriksaan" required>
                                    <option value="Kantor">Kantor</option>
                                    <option value="Lapangan">Lapangan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jadwal_pemeriksaan" class="col-md-4 control-label">Jadwal
                                Pemeriksaan</label>
                            <div class="col-md-100">
                                <input id="jadwal_pemeriksaan" type="date" class="form-control"
                                    name="jadwal_pemeriksaan" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="penerbitan_lhpa" class="col-md-4 control-label">Penerbitan LHPA</label>
                            <div class="col-md-100">
                                <input id="penerbitan_lhpa" type="date" class="form-control" name="penerbitan_lhpa"
                                    required>
                            </div>
                        </div>
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