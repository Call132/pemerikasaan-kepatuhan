@extends('layout.main')

@section('title', 'Edit Data Badan Usaha')
@include('partials.sidebar')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Data Badan Usaha</h1>
        </div>
    </section>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('update-data-pemeriksaan', ['id' => $data->id]) }}" method="post">
                    {{ csrf_field() }}
                    @method('PUT')
    

                    <div class="form-group">
                        <label for="nama_badan_usaha">Nama Badan Usaha</label>
                        <input type="text" class="form-control" id="nama_badan_usaha" name="nama_badan_usaha" value="{{ $data->nama_badan_usaha }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="kode_badan_usaha">Kode Badan Usaha</label>
                        <input type="text" class="form-control" id="kode_badan_usaha" name="kode_badan_usaha" value="{{ $data->kode_badan_usaha }}" required>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required>{{ $data->alamat }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="kota_kab">Kota/Kab</label>
                        <input type="text" class="form-control" id="kota_kab" name="kota_kab" value="{{ $data->kota_kab }}" required>
                    </div>

                    <div class="form-group">
                        <label for="jenis_ketidakpatuhan">Jenis Ketidakpatuhan</label>
                        <input type="text" class="form-control" id="jenis_ketidakpatuhan" name="jenis_ketidakpatuhan" value="{{ $data->jenis_ketidakpatuhan }}" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_terakhir_bayar">Tanggal Terakhir Bayar</label>
                        <input type="date" class="form-control" id="tanggal_terakhir_bayar" name="tanggal_terakhir_bayar" value="{{ $data->tanggal_terakhir_bayar }}" required>
                    </div>

                    <div class="form-group">
                        <label for="jumlah_tunggakan">Jumlah Tunggakan</label>
                        <input type="number" class="form-control" id="jumlah_tunggakan" name="jumlah_tunggakan" value="{{ $data->jumlah_tunggakan }}" required>
                    </div>

                    <div class="form-group">
                        <label for="jenis_pemeriksaan">Jenis Pemeriksaan</label>
                        <input type="text" class="form-control" id="jenis_pemeriksaan" name="jenis_pemeriksaan" value="{{ $data->jenis_pemeriksaan }}" required>
                    </div>

                    <div class="form-group">
                        <label for="jadwal_pemeriksaan">Jadwal Pemeriksaan</label>
                        <input type="date" class="form-control" id="jadwal_pemeriksaan" name="jadwal_pemeriksaan" value="{{ $data->jadwal_pemeriksaan }}" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
