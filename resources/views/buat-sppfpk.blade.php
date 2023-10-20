@extends('layout.main')

@section('title', 'Surat Panggilan Pemeriksaan Kantor')

@push('style')
    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet"
        href="assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css"> --}}

    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Surat Pemberitahuan Panggilan Final Pemeriksaan Kantor</h1>
                <a href="{{ route('sppfpk.preview') }}" class="btn btn-success" style="margin-left: 600px;">Preview</a>
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
                                <form method="POST" action="{{ route('sppfpk.store') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="nomor_sppfpk">Nomor:</label>
                                        <input type="text" class="form-control" id="nomor_sppfpk" name="nomor_sppfpk"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="hari_tanggal_pelaksanaan">Hari/Tanggal Pelaksanaan:</label>
                                        <input type="date" class="form-control" id="hari_tanggal_pelaksanaan"
                                            name="hari_tanggal_pelaksanaan" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="waktu">Waktu:</label>
                                        <input type="time" class="form-control" id="waktu" name="waktu" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="tempat">Tempat:</label>
                                        <input type="text" class="form-control" id="tempat" name="tempat" required>
                                    </div>

                                    <!-- Informasi Petugas Pemeriksa -->
                                    <h3 class="text-center text-black">Informasi Petugas Pemeriksa</h3>
                                    <div class="form-group">
                                        <label for="petugas_pemeriksa_nama">Nama:</label>
                                        <input type="text" class="form-control" id="petugas_pemeriksa_nama"
                                            name="petugas_pemeriksa_nama" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="petugas_pemeriksa_npp">NPP:</label>
                                        <input type="text" class="form-control" id="petugas_pemeriksa_npp"
                                            name="petugas_pemeriksa_npp" required>
                                    </div>

                                    <!-- Informasi Pemberi Kerja -->
                                    <h3 class="text-center">Informasi Pemberi Kerja</h3>
                                    <div class="form-group">
                                        <label for="pemberi_kerja_nama">Nama Pemberi Kerja:</label>
                                        <input type="text" class="form-control" id="pemberi_kerja_nama"
                                            name="pemberi_kerja_nama" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="kode_entitas">Kode Entitas:</label>
                                        <input type="text" class="form-control" id="kode_entitas" name="kode_entitas"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat">Alamat:</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Buat SPPFK</button>
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
        {{-- <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> --}}
        <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        {{-- <script src="{{ asset() }}"></script> --}}
        {{-- <script src="{{ asset() }}"></script> --}}
        <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

        <!-- Page Specific JS File -->
        <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    @endpush
