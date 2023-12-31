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
            <h1>Buat Surat Pemberitahuan Pemeriksaan Lapangan </h1>

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
                        @endif
                    </div>
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <form method="POST" action="{{ route('sppl.store') }}" id="myForm">
                                @csrf
                                <input type="hidden" name="badan_usaha_id" value="{{ $badanUsaha->id }}">

                                <div class="form-group">
                                    <label for="nomor_sppl">Nomor Surat:</label>
                                    <input type="text" class="form-control" id="nomor_sppl" name="nomor_sppl" required>
                                </div>


                                <div class="form-group">
                                    <label for="hari_tanggal_pelaksanaan">Hari/Tanggal Pelaksanaan:</label>
                                    <input type="date" class="form-control" id="hari_tanggal_pelaksanaan"
                                        name="hari_tanggal_pelaksanaan" disabled required
                                        value="{{ $badanUsaha->jadwal_pemeriksaan }}">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_surat">Tanggal Surat:</label>
                                    <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" required>
                                </div>



                                <!-- Informasi Petugas Pemeriksa -->
                                <h3 class="text-center text-black">Informasi </h3>
                                <div class="form-group">
                                    <label for="nama">Nama:</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>

                                <div class="form-group">
                                    <label for="noHp">No Hp:</label>
                                    <input type="text" class="form-control" id="noHp" name="noHp" required>
                                </div>

                                <!-- Informasi Pemberi Kerja -->
                                <h3 class="text-center">Informasi Pemberi kerja</h3>
                                <div class="form-group">
                                    <label for="pemberi_kerja_nama">Nama :</label>
                                    <input type="text" class="form-control" id="pemberi_kerja_nama"
                                        name="pemberi_kerja_nama" value="{{ $badanUsaha->nama_badan_usaha }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="kode_entitas">Kode Entitas:</label>
                                    <input type="text" class="form-control" id="kode_entitas" name="kode_entitas"
                                        disabled value="{{ $badanUsaha->kode_badan_usaha }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat:</label>
                                    <input type="text" value="{{ $badanUsaha->alamat }}" class="form-control"
                                        id="alamat" name="alamat" disabled required>
                                </div>

                                <button type="submit" class="btn btn-primary" onclick="submitForm()">Buat SPPL</button>
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
                }, 5000); // Redirect after 1 second (adjust the delay as needed)
            });
        }
    </script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    @endpush