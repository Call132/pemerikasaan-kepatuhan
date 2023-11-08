@extends('layout.main')

@section('title', 'Form Kertas Kerja')

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
            <h1>Form Kertas Kerja Pemeriksaan</h1>
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
                            <form method="post" action="{{ route('kertas-kerja.store', ['id' => $badanUsaha->id]) }}"
                                id="myForm">
                                @csrf
                                <div class="div text-center">
                                    <h5>Informasi Badan Usaha</h5>
                                </div>
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
                                    <input value="{{ $badanUsaha->npwp }}" type="text" class="form-control" id="npwp" name="npwp" required>
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
                                    <label for="uraian">Uraian :</label>
                                    <input type="text" class="form-control" id="uraian" name="uraian">
                                </div>

                                <div class="form-group">
                                    <label for="tanggapan_bu">Tanggapan Badan Usaha:</label>
                                    <input type="text" class="form-control" name="tanggapan_bu" id="">
                                </div>

                                <div class="div text-center">
                                    <h5>Identifikasi Pekerja</h5>
                                </div>
                                <div class="form-group">
                                    <label for="ref_pekerja">Ref :</label>
                                    <input type="text" class="form-control" id="ref_pekerja" name="ref_pekerja">
                                </div>

                                <div class="form-group">
                                    <label for="pemeriksa">Pemeriksa :</label>
                                    <input type="text" class="form-control" id="pemeriksa" name="pemeriksa">
                                </div>

                                <div class="form-group">
                                    <label for="master_file">Master File :</label>
                                    <input type="text" class="form-control" id="master_file" name="master_file">
                                </div>

                                <div class="form-group">
                                    <label for="koreksi">Koreksi :</label>
                                    <input type="text" class="form-control" id="koreksi" name="koreksi">
                                </div>

                                <div class="div text-center">
                                    <h5>Identifikasi Perhitungan Iuran</h5>
                                </div>
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
                                    <input type="number"  class="form-control"
                                        id="jumlah_bulan_menunggak" name="jumlah_bulan_menunggak">
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
                window.location.href = '/kertas-kerja';
            }, 3000); // Redirect after 1 second (adjust the delay as needed)
        });
    }
    </script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    @endpush