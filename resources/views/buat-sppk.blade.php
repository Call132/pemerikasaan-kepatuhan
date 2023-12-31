@extends('layout.main')

@section('title', 'Surat Panggilan Pemeriksaan Kantor')

@push('style')
<!-- CSS Libraries -->
{{--
<link rel="stylesheet" href="assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css"> --}}

<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Buat Surat Panggilan Pemeriksaan Kantor</h1>
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
                        @elseif (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                            <form method="POST" action="{{ route('sppk.store') }}" id="myForm">
                                @csrf

                                <input type="hidden" name="badan_usaha_id" value="{{ $badanUsaha->id }}">
                                <input type="hidden" name="spt_id" value="{{ $timPemeriksa->surat_perintah_tugas_id }}">


                                <div class="form-group">
                                    <label for="nomor_sppk">Nomor:</label>
                                    <input type="text" class="form-control" id="nomor_sppk" name="nomor_sppk" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_surat">Tanggal Surat:</label>
                                    <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="hari_tanggal_pelaksanaan">Hari/Tanggal Pelaksanaan:</label>
                                    <input type="date" class="form-control" id="hari_tanggal_pelaksanaan"
                                        name="hari_tanggal_pelaksanaan" disabled
                                        value="{{ $badanUsaha->jadwal_pemeriksaan }}">
                                </div>

                                <div class="form-group">
                                    <label for="waktu">Waktu:</label>
                                    <input type="text" class="form-control" id="waktu" name="waktu" required>

                                </div>


                                <!-- Informasi Petugas Pemeriksa -->
                                <h3 class="text-center text-black">Informasi Petugas Pemeriksa</h3>

                                <div class="form-group">
                                    <label for="petugas_pemeriksa_nama">Nama:</label>
                                    <input type="text" class="form-control" id="petugas_pemeriksa_nama"
                                        name="petugas_pemeriksa_nama" value="{{ $timPemeriksa->nama }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="petugas_pemeriksa_npp">NPP:</label>
                                    <input type="text" class="form-control" id="petugas_pemeriksa_npp"
                                        name="petugas_pemeriksa_npp" value="{{ $timPemeriksa->npp }}" disabled>
                                </div>
                                <!-- Informasi Pemberi Kerja -->
                                <h3 class="text-center">Informasi Pemberi Kerja</h3>
                                <div class="form-group">
                                    <label for="pemberi_kerja_nama">Nama Pemberi Kerja:</label>
                                    <input type="text" class="form-control" id="pemberi_kerja_nama"
                                        name="pemberi_kerja_nama" disabled value="{{ $badanUsaha->nama_badan_usaha }}">
                                </div>

                                <div class="form-group">
                                    <label for="kode_entitas">Kode Entitas:</label>
                                    <input type="text" class="form-control" id="kode_entitas" name="kode_entitas"
                                        disabled value="{{ $badanUsaha->kode_badan_usaha }}">
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat:</label>
                                    <input type="text" value="{{ $badanUsaha->alamat }}" class="form-control"
                                        id="alamat" name="alamat" disabled>
                                </div>
                                <button type="submit" onclick="submitForm()" class="btn btn-primary">Buat SPPK</button>
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
    <script>
        function submitForm() {
            document.getElementById('myForm').addEventListener('submit', function() {
                setTimeout(function() {
                    window.location.href = '/pengiriman-surat';
                }, 3000); // Redirect after 1 second (adjust the delay as needed)
            });
        }
    </script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    @endpush