@extends('layout.main')

@section('title', 'User')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Management User</h1>
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
    <section class="section">
        <div class="card">
            <div class="card-body">
                <table class="table table-simple" id="userTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->role }}</td>
                            <td><a href="{{ route('user.edit', $data->id) }}" class="btn btn-warning"><i
                                        class="fa-solid fa-pen"></i></a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <a href="{{ route('user.create') }} " class="btn btn-primary mb-2">Tambah <i
                                class="fa-solid fa-plus-circle"></i></a>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
</div>
@include('components.deleteModal', [
'modalId' => 'confirmDeleteModal',
'modalTitle' => 'Konfirmasi Hapus Data',
'modalBody' => 'Apakah Anda yakin ingin menghapus data ini?',
'confirmDeleteRoute' => route('user.destroy', $data->id),
])
@endsection
@push('style')
<style>
    #userTable thead {
        background-color: #5b5d5f;
        /* Ganti dengan warna yang diinginkan */
        color: #000000;
        /* Ganti dengan warna teks yang kontras */
    }

    #userTable thead th {
        border: 2px solid #000000;
        text-align: center;
        /* Ganti dengan warna garis sesuai kebutuhan */

    }

    #userTable tbody td {
        border: 2px solid #000000;
        /* Ganti dengan warna garis sesuai kebutuhan */
    }

    #userTable tbody td:nth-child(4),
    /* Sesuaikan dengan indeks kolom yang ingin ditengahkan (indeks dimulai dari 1) */
    #userTable tbody td:nth-child(5) {
        text-align: center;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        $('#userTable').DataTable({
            "dom": '<"top"lf>rt<"bottom"ip><"clear">', 
        });
    });
</script>
@endpush