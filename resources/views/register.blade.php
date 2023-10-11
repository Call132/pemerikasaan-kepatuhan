@extends('layout.auth')

@section('title', 'Register')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')

    <div class="card card-primary">
        <div class="card-header">
            <h4>Register</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ Route('user.register') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" class="form-control" name="name" autofocus>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback">
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input id="phone" type="text" class="form-control" name="phone">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group ">
                    <label for="password" class="d-block">Password</label>
                    <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator"
                        name="password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="password2" class="d-block">Password Confirmation</label>
                    <input id="password2" type="password" class="form-control" name="password_confirmation">
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
@endsection


@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/auth-register.js') }}"></script>
@endpush
