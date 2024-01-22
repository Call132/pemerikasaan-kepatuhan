@extends('layout.main')

@section('title', 'Kertas Kerja Pemeriksaan')

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Kertas Kerja Pemeriksaan</h1>
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
    <form action="{{ route('kertas-kerja.store', $badanUsaha->id) }}" method="post">
        @csrf
        <input type="hidden" name="bu_id" value="{{ $badanUsaha->id }}">

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
                                    <input id="nama_badan_usaha" value="{{ $badanUsaha->nama_badan_usaha }}" type="text"
                                        class="form-control" name="nama_badan_usaha" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kode_badan_usaha" class="col-md-4 control-label">Kode Badan
                                Usaha</label>
                            <div class="col-md-50">
                                <input id="kode_badan_usaha" value="{{ $badanUsaha->kode_badan_usaha }}" type="text"
                                    class="form-control" name="kode_badan_usaha" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alamat" class="col-md-4 control-label">Alamat</label>
                            <div class="col-md-100">
                                <input id="alamat" value="{{ $badanUsaha->alamat }}" type="text" class="form-control"
                                    name="alamat" readonly></input>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="npwp" class="col-md-4 control-label">NPWP</label>
                            <div class="col-md-100">
                                <input type="text" value="{{ $badanUsaha->npwp}}" id="npwp" class="form-control"
                                    name="npwp" required></input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pemeriksaan" class="col-md-4 control-label">Bulan Pemeriksaan</label>
                            <div class="col-md-100">
                                <input value="{{ $jadwal_pemeriksaan}}" id="tanggal_pemeriksaan" type="text"
                                    class="form-control" name="tanggal_pemeriksaan" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_pemeriksaan" class="col-md-4 control-label">Mekanisme Pemeriksaan</label>
                            <div class="col-md-100">
                                <input value="{{ $badanUsaha->jenis_pemeriksaan}}" id="jenis_pemeriksaan" type="text"
                                    class="form-control" name="jenis_pemeriksaan" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jenis_ketidakpatuhan" class="col-md-4 control-label">Jenis
                                Ketidakpatuhan</label>
                            <div class="col-md-100">
                                <input value="{{ $badanUsaha->jenis_ketidakpatuhan}}" id="jenis_ketidakpatuhan"
                                    type="text" class="form-control" name="jenis_ketidakpatuhan" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="uraian" class="col-md-4 control-label">Uraian</label>
                            <div class="col-md-100">
                                <input id="uraian" type="text" class="form-control" name="uraian" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggapan_bu" class="col-md-4 control-label">Tanggapan Badan Usaha</label>
                            <div class="col-md-100">
                                <input id="tanggapan_bu" type="text" class="form-control" name="tanggapan_bu" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-12 mt-3">
            <div class="card-header">
                <h4>Identifikasi Pekerja</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ref_pekerja">Ref :</label>
                            <input type="text" class="form-control" id="ref_pekerja" name="ref_pekerja">
                        </div>

                        <div class="form-group">
                            <label for="pemeriksa">Pemeriksa :</label>
                            <input type="text" class="form-control" id="pemeriksa" name="pemeriksa">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="master_file">Master File :</label>
                            <input type="text" class="form-control" id="master_file" name="master_file">
                        </div>

                        <div class="form-group">
                            <label for="koreksi">Koreksi :</label>
                            <input type="text" class="form-control" id="koreksi" name="koreksi">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-12 mt-3">
            <div class="card-header">
                <h4>Identifikasi Perhitungan Iuran</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ref_iuran">Ref:</label>
                            <input type="text" class="form-control" id="ref_iuran" name="ref_iuran">
                        </div>
                        <div class="form-group">
                            <label for="total_pekerja">Total Pekerja:</label>
                            <input type="number" class="form-control" id="total_pekerja" name="total_pekerja">
                        </div>
                        <div class="form-group">
                            <label for="jumlah_bulan_menunggak">Jumlah Bulan Menunggak:</label>
                            <input type="number" class="form-control" id="jumlah_bulan_menunggak"
                                name="jumlah_bulan_menunggak">
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