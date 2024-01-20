@extends('layout.main')

@section('title', 'Profil Pengguna')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Profil Pengguna</h1>
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
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div class="card col-12 mt-1">
            <div class="card-header">
                <h4>Data Pengguna</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="name" class="mb-md-0 w-100 mb-2 text-start">Username:</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}"
                            required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="email" class="mb-md-0 w-100 mb-2 text-start">Email:</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ Auth::user()->email }}" required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="password_old" class="mb-md-0 w-100 mb-2 text-start">Password Lama:</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="password" name="password_old" id="password_old" class="form-control" required>
                        @error('password_old')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="password" class="mb-md-0 w-100 mb-2 text-start">Password Baru:</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="password" name="password" id="password" class="form-control" required>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="password_confirmation" class="mb-md-0 w-100 mb-2 text-start">Konfirmasi Password
                            Baru
                            :</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex ">
            <button type="submit" class="btn btn-primary w-100">Simpan perubahan</button>
        </div>
    </form>
</div>
@endsection