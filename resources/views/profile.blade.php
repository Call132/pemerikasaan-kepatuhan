@extends('layout.main')
@section('title', 'Profil Pengguna')

@push('style')

@endpush

@section('main')
<div class="row">
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Profil Pengguna</h1>
            </div>
        </section>
        <div class="card">
        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            <div class="card-body">
                <div class="row">                               
                    <div class="form-group col-md-6 col-12">
                        <label>Username</label>
                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required="">
                        <div class="invalid-feedback">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required="">
                        <div class="invalid-feedback">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Phone</label>
                        <input type="tel" class="form-control" name="phone" value="{{ Auth::user()->phone }}">
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan perubahan</button>
            </div>
        </form>
        </div>

    </div>
</div>
@endsection
