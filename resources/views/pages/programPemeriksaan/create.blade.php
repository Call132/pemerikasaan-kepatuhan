@extends('layout.main')

@section('title', 'Program Realisassi Pemeriksaan')

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Program Realisasi Pemeriksaan</h1>
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
    <form action="{{ route('program-pemeriksaan.store', $badanUsaha->id) }}" method="post">
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
                                <input type="text" id="npwp" class="form-control" name="npwp" required></input>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_pemeriksaan" class="col-md-4 control-label">Bulan Pemeriksaan</label>
                            <div class="col-md-100">
                                <input value="{{ $jadwal_pemeriksaan}}" id="tanggal_pemeriksaan" type="text"
                                    class="form-control" name="tanggal_pemeriksaan" readonly>
                            </div>
                        </div>
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
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-12 mt-3">
            <div class="card-header">
                <h4>Uraian</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="div">Aspek Tenaga Kerja</div>
                            <label>Realisasi</label><br>
                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="aspek_tenaga_kerja" value="Ya" required>
                                    <span>Ya</span>
                                </label>
                            </div>
                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="aspek_tenaga_kerja" value="Tidak" required>
                                    <span>Tidak</span>
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="div">Aspek Iuran</div>
                            <label>Realisasi</label><br>
                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="aspek_iuran" value="Ya" required>
                                    <span>Ya</span>
                                </label>
                            </div>
                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="aspek_iuran" value="Tidak" required>
                                    <span>Tidak</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-12 mt-3">
            <div class="card-header">
                <h4>Dokumen yang dipinjam/Diperlihatkan</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Peraturan perusahaan terkait ketenagakerjaan</label>
                            <p>
                                a. Skala gaji
                            </p>
                            <p>
                                b. Jenjang jabatan
                            </p>
                            <p>
                                c. Sistem pengupahan
                            </p>
                            <p>
                                d. Tunjangan tetap
                            </p>
                            <p>
                                e. Jaminan kesehatan pegawai
                            </p>

                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="peraturan_perusahaan" value="Ya" required>
                                    <span>Ada</span>
                                </label>
                            </div>
                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="peraturan_perusahaan" value="Tidak" required>
                                    <span>Tidak Ada</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Daftar seluruh pekerja berdasarkan jenjang jabatan disertai dengan NIK
                                Pekerja</label>
                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="daftar_pekerja" value="Ya" required>
                                    <span>Ada</span>
                                </label>
                            </div>
                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="daftar_pekerja" value="Tidak" required>
                                    <span>Tidak Ada</span>
                                </label>
                            </div>
                        </div>


                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Struktur Organisasi</label>
                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="struktur_organisasi" value="Ya" required>
                                    <span>Ada</span>
                                </label>
                            </div>
                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="struktur_organisasi" value="Tidak" required>
                                    <span>Tidak Ada</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Daftar Slip Gaji Seluruh Pekerja</label>
                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="daftar_slip_gaji" value="Ya" required>
                                    <span>Ada</span>
                                </label>
                            </div>
                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="daftar_slip_gaji" value="Tidak" required>
                                    <span>Tidak Ada</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Slip Gaji Pekerja</label>
                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="slip_gaji" value="Ya" required>
                                    <span>Ada</span>
                                </label>
                            </div>
                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="slip_gaji" value="Tidak" required>
                                    <span>Tidak Ada</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Absensi Pekerja</label>
                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="absensi" value="Ya" required>
                                    <span>Ada</span>
                                </label>
                            </div>
                            <div class="div">
                                <label class="radio-label">
                                    <input type="radio" name="absensi" value="Tidak" required>
                                    <span>Tidak Ada</span>
                                </label>
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