@extends('layout.main')

@section('title', 'Surat Perintah Tugas')

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Surat Perintah Tugas</h1>
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
    <form action="{{ route('spt.store') }}" method="POST">
        @csrf
        <div class="card col-12 mt-1">
            <div class="card-header">
                <h4>Data Surat Perintah Tugas</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="nomor_spt" class="mb-md-0 w-100 mb-2 text-start">Nomor Surat Perintah Tugas :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="nomor_spt" id="nomor_spt" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="tanggal_spt" class="mb-md-0 w-100 mb-2 text-start">Tanggal Surat Perintah Tugas :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="date" name="tanggal_spt" id="tanggal_spt" class="form-control" required>
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
                        <label for="petugas_pemeriksa_nama" class="mb-md-0 w-100 mb-2 text-start">Nama Petugas Pemeriksa
                            :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="petugas_pemeriksa_nama" id="petugas_pemeriksa_nama"
                            class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="petugas_pemeriksa_npp" class="mb-md-0 w-100 mb-2 text-start">NPP Petugas Pemeriksa :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="petugas_pemeriksa_npp" id="petugas_pemeriksa_npp" class="form-control"
                            required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-12 mt-1 pendamping">
            <div class="card-header">
                <h4>Informasi Petugas Pendamping</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="pendamping_nama" class="mb-md-0 w-100 mb-2 text-start">Nama Petugas Pendamping :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="pendamping_nama[]" id="pendamping_nama" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="pendamping_npp" class="mb-md-0 w-100 mb-2 text-start">NPP Petugas Pendamping :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="pendamping_npp[]" id="pendamping_npp" class="form-control" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success mb-2 tambah_pendamping">Tambah
                Pendamping</button>
        </div>
        <div class="card col-12 mt-1">
            <div class="card-header">
                <h4>Informasi Pendamping Eksternal</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="ext_pendamping_nama" class="mb-md-0 w-100 mb-2 text-start">Nama :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="ext_pendamping_nama" id="ext_pendamping_nama" class="form-control"
                            required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="jabatan" class="mb-md-0 w-100 mb-2 text-start">Jabatan :
                        </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="jabatan" id="jabatan" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex ">
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div>
    </form>
</div>

@endsection
@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fungsi untuk menambah kolom pendamping
        $(".tambah_pendamping").click(function() {
            var pendampingHtml = `
                <div class="card col-12 mt-1 pendamping">
                    <div class="card-header">
                        <h4>Informasi Petugas Pendamping</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-12 col-md-3">
                                <label for="pendamping_nama" class="mb-md-0 w-100 mb-2 text-start">Nama Petugas Pendamping :
                                </label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" name="pendamping_nama[]" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-3">
                                <label for="pendamping_npp" class="mb-md-0 w-100 mb-2 text-start">NPP Petugas Pendamping :
                                </label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" name="pendamping_npp[]" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger hapus_pendamping mb-2">Hapus Pendamping</button>
                    </div>
                    `
                    ;

            $(".pendamping").last().after(pendampingHtml);
        });

        // Fungsi untuk menghapus kolom pendamping
        $(document).on("click", ".hapus_pendamping", function() {
            $(this).closest(".pendamping").remove();
        });
    });
</script>