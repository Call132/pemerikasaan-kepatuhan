@extends('layout.auth')

@section('title', 'Login')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
@endpush

@section('main')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card card-primary">

        <div class="card-header">
            <h4>LOGIN</h4>
            <h4>SIS-RISKA</h4>
            <p>Sistem Informasi Pemeriksaan Kepatuhan</p>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('user.login') }}" class="needs-validation" novalidate="">
                @csrf
                <div class="form-group">
                    <label for="name">Username</label>
                    <input id="name" type="text"  class="form-control @error('name') is-invalid 
                        
                    @enderror" name="name" tabindex="1" required
                        autofocus value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback">
                        Please fill in your Username
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback">
                        please fill in your password
                    </div>
                </div>

               

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Login
                    </button>
                </div>
            </form>


        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
