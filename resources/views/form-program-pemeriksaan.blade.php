@extends('layout.main')

@section('title', 'Form Program Pemeriksaan')

@push('style')
<!-- CSS Libraries -->

<link rel="stylesheet" href="assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush



@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Program Pemeriksaan</h1>
        </div>
    </section>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <p class="card-text">
                <div class="col-md-100">
                    <div class="col-md-100">
                        @if (session('error'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('error') }}
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
                            <form method="post"
                                action="{{ route('program-pemeriksaan.store', ['id' => $badanUsaha->id]) }}" id="myForm">
                                @csrf
                                <input type="hidden" name="bu_id" value="{{ $badanUsaha->id }}">

                                <div class="form-group">
                                    <label for="nama_bu">Nama Badan Usaha:</label>
                                    <input value="{{ $badanUsaha->nama_badan_usaha }}" type="text" class="form-control"
                                        id="nama_bu" name="nama_bu" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat Badan Usaha:</label>
                                    <input value="{{ $badanUsaha->alamat }}" type="text" class="form-control"
                                        id="alamat" name="alamat" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="kode_bu">Kode Badan Usaha:</label>
                                    <input value="{{ $badanUsaha->kode_badan_usaha }}" type="text" class="form-control"
                                        id="kode_bu" name="kode_bu" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="npwp">NPWP:</label>
                                    <input type="text" class="form-control" id="npwp" name="npwp" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_pemeriksaan">Bulan Pemeriksaan:</label>
                                    <input value="{{ $jadwal_pemeriksaan}}" type="text" class="form-control"
                                        id="tanggal_pemeriksaan" name="tanggal_pemeriksaan" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_pemeriksaan">Mekanisme Pemeriksaan:</label>
                                    <input value="{{ $badanUsaha->jenis_pemeriksaan}}" type="text" class="form-control"
                                        id="jenis_pemeriksaan" name="jenis_pemeriksaan" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_ketidakpatuhan">Jenis Ketidakpatuhan:</label>
                                    <input value="{{ $badanUsaha->jenis_ketidakpatuhan}}" type="text"
                                        class="form-control" id="jenis_ketidakpatuhan" name="jenis_ketidakpatuhan"
                                        disabled>
                                </div>
                                <div class="form-group">
                                    <h5 class="text-center">Uraian</h5>
                                </div>

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

                                <div class="form-group">
                                    <h5 class="text-center">Dokumen yang dipinjam/Diperlihatkan</h5>
                                </div>

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

                                <button type="submit" class="btn btn-primary " onclick="submitForm()">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('scripts')

    <!-- JS Libraies -->
    <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script>
        function submitForm() {
        document.getElementById('myForm').addEventListener('submit', function() {
            setTimeout(function() {
                window.location.href = '/program-pemeriksaan';
            }, 3000); // Redirect after 1 second (adjust the delay as needed)
        });
    }
    </script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    @endpush