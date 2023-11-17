<!-- edit-user.blade.php -->
@extends('layout.main')

@section('title', 'Edit Pengguna')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Pengguna</h1>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit User</h4>
                </div>
    
                <div class="card-body">
                    <!-- Form Edit User -->
                    <form action="{{ route('user.update', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <!-- Input Nama -->
                        <div class="form-group ">
                            <label for="name">Nama Pengguna</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                                required>
                        </div>

                        <!-- Input Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                                required>
                        </div>

                        <!-- Input Phone -->
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                        </div>

                        <!-- Input Role -->
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="admin" @if ($user->role_name == 'admin') selected @endif>Admin</option>
                                <option value="user" @if ($user->role_name == 'user') selected @endif>User</option>
                            </select>
                        </div>

                        <!-- Tombol Simpan -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection