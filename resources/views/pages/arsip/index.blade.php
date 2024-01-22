@extends('layout.main')

@section('title', 'Arsip')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Arsip</h1>
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
                <table class="table table-simple" id="arsipSuratTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nomor Surat / File</th>
                            <th>Jenis Surat</th>
                            <th>Tanggal Surat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surat as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->nomor_surat }}</td>
                            <td>{{ $data->jenis_surat }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal_surat)->translatedFormat('d F Y') }}</td>
                            <td> @if (url($data->file_path))
                                <a href="{{ url($data->file_path) }}" download><i
                                        class="fa-solid fa-file-arrow-down"></i><span> Download</span></a>
                                @else
                                File not found
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#arsipSuratTable').DataTable();
    });
</script>
@endpush