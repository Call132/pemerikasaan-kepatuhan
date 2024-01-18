@extends('layout.main')

@section('title', 'Tambah Badan Usaha')

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Update Data Badan Usaha</h1>
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
    <form action="{{ route('badanusaha.update', $badanUsaha->id) }}" method="post">
        @method('PUT')
        @csrf
        <input type="hidden" name="perencanaan_id" value="{{ $badanUsaha->id }}">
        <div class="card col-12 mt-3">
            <div class="card-header">
                <h4>Data Badan Usaha</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_badan_usaha" class="col-md-4 control-label">Nama Badan Usaha</label>
                            <input type="text" class="form-control" id="nama_badan_usaha" name="nama_badan_usaha"
                                value="{{ $badanUsaha->nama_badan_usaha }}" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="kode_badan_usaha" class="col-md-4 control-label">Kode Badan Usaha</label>
                            <input type="text" class="form-control" id="kode_badan_usaha" name="kode_badan_usaha"
                                value="{{ $badanUsaha->kode_badan_usaha }}" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="col-md-4 control-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat"
                                required>{{ $badanUsaha->alamat }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="kota_kab" class="col-md-4 control-label">Kota/Kab</label>
                            <input type="text" class="form-control" id="kota_kab" name="kota_kab"
                                value="{{ $badanUsaha->kota_kab }}" required>
                        </div>

                        <div class="form-group">
                            <label for="jenis_ketidakpatuhan" class="col-md-4 control-label">Jenis
                                Ketidakpatuhan</label>
                            <input type="text" class="form-control" id="jenis_ketidakpatuhan"
                                name="jenis_ketidakpatuhan" value="{{ $badanUsaha->jenis_ketidakpatuhan }}" required>
                        </div>


                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_terakhir_bayar" class="col-md-4 control-label">Tanggal Terakhir
                                Bayar</label>
                            <input type="date" class="form-control" id="tanggal_terakhir_bayar"
                                name="tanggal_terakhir_bayar" value="{{ $badanUsaha->tanggal_terakhir_bayar }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="jumlah_tunggakan" class="col-md-4 control-label">Jumlah Tunggakan</label>
                            <input type="number" class="form-control" id="jumlah_tunggakan" name="jumlah_tunggakan"
                                value="{{ $badanUsaha->jumlah_tunggakan }}" required>
                        </div>

                        <div class="form-group">
                            <label for="jenis_pemeriksaan" class="col-md-4 control-label">Jenis
                                Pemeriksaan</label>
                            <div class="col-md-100">
                                <select id="jenis_pemeriksaan" class="form-control" name="jenis_pemeriksaan" required>
                                    <option value="Kantor" {{ $badanUsaha->jenis_pemeriksaan === 'Kantor' ? 'selected' :
                                        '' }}>Kantor</option>
                                    <option value="Lapangan" {{ $badanUsaha->jenis_pemeriksaan === 'Lapangan' ?
                                        'selected' : '' }}>Lapangan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jadwal_pemeriksaan" class="col-md-4 control-label">Jadwal Pemeriksaan</label>
                            <input type="date" class="form-control" id="jadwal_pemeriksaan" name="jadwal_pemeriksaan"
                                value="{{ $badanUsaha->jadwal_pemeriksaan }}" required>
                        </div>
                        <div class="form-group">
                            <label for="penerbitan_lhpa" class="col-md-4 control-label">Penerbitan LHPA</label>
                            <div class="col-md-100">
                                <input id="penerbitan_lhpa" type="date" class="form-control" name="penerbitan_lhpa"
                                    value="{{ $badanUsaha->penerbitan_lhpa }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary w-100">Update</button>
        </div>
    </form>
</div>

@endsection