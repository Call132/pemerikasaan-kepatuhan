@extends('layout.main')

@section('title', 'Create User')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Tambah User</h1>
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
    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <div class="card col-12 mt-1">
            <div class="card-header">
                <h4>Data User</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="name" class="mb-md-0 w-100 mb-2 text-start">Username:</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
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
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                            required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="password" class="mb-md-0 w-100 mb-2 text-start">Password:</label>
                        
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
                        <label for="role" class="mb-md-0 w-100 mb-2 text-start">Role:</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <select name="role" id="role" class="form-control" required>
                            <option value="User Entry" {{ old('role') == 'User Entry' ? 'selected' : '' }}>User Entry</option>
                            <option value="User Approval" {{ old('role') == 'User Approval' ? 'selected' : '' }}>User Approval</option>
                            <option value="Kepala Cabang" {{ old('role') == 'Kepala Cabang' ? 'selected' : '' }}>Kepala Cabang</option>
                        </select>
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