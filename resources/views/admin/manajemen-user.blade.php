@extends('layout.main')

@section('title', 'Manajemen Pengguna')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Manajemen Pengguna</h1>
        </div>
        @if (session('success'))
        <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                {{ session('success') }}
            </div>
        </div>
        @elseif (session('error'))
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
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            <td>@if ($user->role_name == 'admin')
                                <span class="badge badge-light"> {{ $user->role_name }} </span>
                                @else
                                <span class="badge badge-light"> {{ $user->role_name }} </span>

                                @endif
                            </td>
                            <td>
                                <!-- Tombol aksi untuk mengedit atau menghapus pengguna -->
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning"><i
                                        class="fa fa-edit"></i></a>
                                <form action="{{ route('user.destroy', $user->id) }}" method="post"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#confirmDeleteModal">
                                        <i class="fa fa-trash"></i>
                                    </button>


                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <form action="{{ route('user.create') }}" method="get">
                            <button type="submit" class="btn btn-primary" style="margin-bottom: 10px">Tambah <i
                                    class="fas fa-plus-square"></i></button>
                        </form>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus pengguna ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('user.destroy', $user->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete() {
        if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
<!-- Tambahkan modal atau form manajemen pengguna jika diperlukan -->

@endsection