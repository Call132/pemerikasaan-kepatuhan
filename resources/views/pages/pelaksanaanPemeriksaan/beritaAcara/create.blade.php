@extends('layout.main')

@section('title', 'Berita Acara Pemeriksaan')

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Berita Acara Pemeriksaan</h1>
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
    <form action="{{ route('berita-acara.store', $badanUsaha->id) }}" method="post">
        @csrf
        <input type="hidden" value="{{ $spt->id }}" name="spt_id">
        <input type="hidden" value="{{ $badanUsaha->id }}" name="bu_id">
        <div class="card col-12 mt-3">
            <div class="card-header">
                <h4>Informasi Pemberi Kerja</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="Nama" class="col-md-4 control-label">Nama</label>
                                <div class="col-md-100">
                                    <input id="nama_pemberi_kerja" type="text" class="form-control"
                                        name="nama_pemberi_kerja" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="jabatan" class="col-md-4 control-label">Jabatan</label>
                                <div class="col-md-100">
                                    <input id="jabatan" type="text" class="form-control" name="jabatan" required>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        <label for="timPemeriksa" class="mb-md-0 w-100 mb-2 text-start">Nama Petugas Pemeriksa
                            :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" value="{{ $timPemeriksa->nama }}" name="timPemeriksa" id="timPemeriksa"
                            class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="timPemeriksaNpp" class="mb-md-0 w-100 mb-2 text-start">NPP Petugas Pemeriksa :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" value="{{ $timPemeriksa->npp }}" name="timPemeriksaNpp" id="timPemeriksaNpp"
                            class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-12 mt-3">
            <div class="card-header">
                <h4>Berita Acara Pengambilan Keterangan</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_bapket">Nomor Surat Berita Acara Pengambilan Keterangan :</label>
                            <input type="text" class="form-control" id="no_bapket" name="no_bapket">
                        </div>

                        <div class="form-group">
                            <label for="tgl_bapket">Tanggal Berita Acara Pengambilan Keterangan :</label>
                            <input type="date" class="form-control" id="tgl_bapket" name="tgl_bapket">
                        </div>

                        <div class="form-group">
                            <label for="tunggakanIuran">Jumlah Tunggakan Iuran :</label>
                            <input value="{{ $badanUsaha->jumlah_tunggakan }}" type="number" class="form-control"
                                id="tunggakanIuran" name="tunggakanIuran">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bulanMenunggak">Jumlah Bulan Menunggak :</label>
                            <input type="number" class="form-control" id="bulanMenunggak" name="bulanMenunggak">
                        </div>
                        <div class="form-group">
                            <label for="sebabMenunggak">Sebab Menunggak :</label>
                            <input type="text" class="form-control" id="sebabMenunggak" name="sebabMenunggak">
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