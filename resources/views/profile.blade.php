@extends('layout.main')
@section('title', 'Profil Pengguna')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/prismjs/themes/prism.min.css') }}">
@endpush

@section('main')
<div class="row">
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
        <div class="card">
            <form method="post" action="{{ route('profile.update') }}  " id="updateProfileForm">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Username : </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}"
                                required="">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Email : </label>
                        <div class="col-sm-9">
                            <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control"
                                id="inputEmail3" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPhone" class="col-sm-3 col-form-label">Phone</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPasswordOld" class="col-sm-3 col-form-label">Password Lama:</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password_old" placeholder="Password Lama">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Password Baru:</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password" placeholder="New Password">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Simpan perubahan</button>
                    </div>
                </div>
            </form>

        </div>

    </div>
</div>
<!-- Update Confirmation Modal -->
<div class="modal" tabindex="-1" role="dialog" id="updateConfirmationModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to save changes?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmUpdate">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const updateForm = document.getElementById('updateProfileForm');
        const updateConfirmationModal = new bootstrap.Modal(document.getElementById('updateConfirmationModal'));

        updateForm.addEventListener('submit', function (event) {
            event.preventDefault();
            updateConfirmationModal.show();
        });

        document.getElementById('confirmUpdate').addEventListener('click', function () {
            updateForm.submit();
        });
    });
</script>

@endsection
@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/prismjs/prism.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/bootstrap-modal.js') }}"></script>
@endpush