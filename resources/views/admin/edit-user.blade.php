<!-- edit-user.blade.php -->
@extends('layout.main')

@section('title', 'Edit Pengguna')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Pengguna</h1>
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
        <div class="card-header">
            <h4>Form Edit User</h4>
        </div>

        <div class="card-body">
            <!-- Form Edit User -->
            <form action="{{ route('user.update', $user->id) }}" method="post" id="updateProfileForm">
                @csrf
                @method('PUT')

                <!-- Input Nama -->
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Nama Pengguna</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                            required>
                    </div>
                </div>

                <!-- Input Email -->
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                            required>
                    </div>
                </div>

                <!-- Input Phone -->
                <div class="form-group row">
                    <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                    </div>
                </div>

                <!-- Input Role -->
                <div class="form-group row">
                    <label for="role" class="col-sm-3 col-form-label">Role</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="role" name="role" required>
                            <option value="user entry" @if ($user->role_name == 'user entry') selected @endif>User Entry
                            </option>
                            <option value="user approval" @if ($user->role_name == 'user approval') selected @endif>User
                                Approval</option>

                        </select>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Simpan perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Update Confirmation Modal -->
<div class="modal" tabindex="0" role="dialog" id="updateConfirmationModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to save changes?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmUpdate">Save changes</button>
                <button type="button" class="btn btn-secondary" id='close' data-dismiss="modal">Close</button>
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
            updateConfirmationModal.hide();
            updateForm.submit();
        });
        document.getElementById('close').addEventListener('click', function () {
            updateConfirmationModal.hide();
        });
    });
</script>
@endsection