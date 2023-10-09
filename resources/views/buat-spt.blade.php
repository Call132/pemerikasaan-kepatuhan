@extends('layout.main')

@section('title', 'Surat Perintah Tugas')

@push('style')
    <!-- CSS Libraries -->
   {{-- <link rel="stylesheet"
        href="assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css"> --}}

    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main') 

<div class="row">

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Buat Surat Perintah Tugas</h1>
        </div>
    </section>
<div class="container">
<div class="card">
 
  <div class="card-body">
  
    
    <p class="card-text"><div class="col-md-100">
                             <div class="col-md-100">
                                @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
                            </div></p>
                            
        
 
  </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
             
                <form method="POST" action="{{ route('spt.create') }}">
                        @csrf
                    
                        <div class="form-group">
                            <label for="nomor_spt">Nomor SPT:</label>
                            <input type="text" class="form-control" id="nomor_spt" name="nomor_spt" required>
                        </div>
                    
                        <div class="form-group">
                            <label for="tanggal_spt">Tanggal SPT:</label>
                            <input type="date" class="form-control" id="tanggal_spt" name="tanggal_spt" required>
                        </div>  
                        {{-- <div class="form-group">
                            <label for="lampiran_badan_usaha">Lampiran Badan Usaha:</label>
                            <input type="file" class="form-control-file" id="lampiran_badan_usaha" name="lampiran_badan_usaha" required>
                        </div> --}}
                    
                        <!-- Informasi Petugas Pemeriksa -->
                        <h3 class="text-center text-black">Informasi Petugas Pemeriksa</h3>
                        <div class="form-group">
                            <label for="petugas_pemeriksa_nama">Nama Petugas Pemeriksa:</label>
                            <input type="text" class="form-control" id="petugas_pemeriksa_nama" name="petugas_pemeriksa_nama" required>
                        </div>
                        <div class="form-group">
                            <label for="petugas_pemeriksa_npp">NPP Petugas Pemeriksa:</label>
                            <input type="text" class="form-control" id="petugas_pemeriksa_npp" name="petugas_pemeriksa_npp" required>
                        </div>
                    
                        <!-- Informasi Pendamping -->
                        <h3 class="text-center">Informasi Pendamping</h3>
                        <div class="pendamping">
                            <div class="form-group">
                                <label for="pendamping_nama">Nama Pendamping:</label>
                                <input type="text" class="form-control" name="pendamping_nama[]" required>
                            </div>
                            <div class="form-group">
                                <label for="pendamping_npp">NPP Pendamping:</label>
                                <input type="text" class="form-control" name="pendamping_npp[]" required>
                            </div>
                            
                        </div>
                        <button type="button" class="btn btn-success mb-2" id="tambah_pendamping">Tambah Pendamping</button>

                        
                        <!-- Jabatan -->
                        <div class="form-group">
                            <label for="jabatan">Jabatan:</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Buat SPT</button>
                        </form>
                    

                                
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Fungsi untuk menambah kolom pendamping
        $("#tambah_pendamping").click(function() {
            var pendampingHtml = `
                <div class="pendamping">
                    <div class="form-group">
                        <label for="pendamping_nama">Nama Pendamping:</label>
                        <input type="text" class="form-control" name="pendamping_nama[]" required>
                    </div>
                    <div class="form-group">
                        <label for="pendamping_npp">NPP Pendamping:</label>
                        <input type="text" class="form-control" name="pendamping_npp[]" required>
                    </div>
                    <button type="button" class="btn btn-danger hapus_pendamping mb-2">Hapus Pendamping</button>
                </div>
            `;
    
            $(".pendamping").last().after(pendampingHtml);
        });
    
        // Fungsi untuk menghapus kolom pendamping
        $(document).on("click", ".hapus_pendamping", function() {
            $(this).closest(".pendamping").remove();
        });
    });
    </script>
    
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