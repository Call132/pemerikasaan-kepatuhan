@extends('layout.main')

@section('title', 'Tambah Data BU')

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

    <div class="row">

        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Tambah Data Badan Usaha</h1>
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
                        </div>
                        </p>
                        <p class="card-text">
                        <div class="col-md-100">
                            <div class="col-md-100">
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        </p>



                    </div>

                    <div class="row">
                        <div class="col-md-10 ">
                            <div class="panel panel-default">

                                <div class="card-body">
                                    <form
                                        action="{{ route('data-pemeriksaan.store', ['perencanaan_id' => $perencanaan_id]) }}"
                                        method="post">
                                        <div class="panel-body">

                                            {{ csrf_field() }}
                                            <input type="hidden" name="perencanaan_id" value="{{ $perencanaan_id }}">

                                            <div class="form-group">
                                                <label for="nama_badan_usaha" class="col-md-4 control-label">Nama Badan
                                                    Usaha</label>
                                                <div class="col-md-100">
                                                    <input id="nama_badan_usaha" type="text" class="form-control"
                                                        name="nama_badan_usaha" required autofocus>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="kode_badan_usaha" class="col-md-4 control-label">Kode Badan
                                                    Usaha</label>
                                                <div class="col-md-50">
                                                    <input id="kode_badan_usaha" type="text" class="form-control"
                                                        name="kode_badan_usaha" required>
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
                                                    <input id="kota_kab" type="text" class="form-control"
                                                        name="kota_kab" required>
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
                                                    <input id="jumlah_tunggakan" type="number" class="form-control"
                                                        name="jumlah_tunggakan" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="jenis_pemeriksaan" class="col-md-4 control-label">Jenis
                                                    Pemeriksaan</label>
                                                <div class="col-md-100">
                                                    <select id="jenis_pemeriksaan" class="form-control"
                                                        name="jenis_pemeriksaan" required>
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
                                                <div class="col-md-100 col-md-offset-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        Simpan Data
                                                    </button>
                                                </div>
                                            </div>
                                    </form>
                                </div>
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
