@extends('layout.main')

@section('title', 'Laporan Monitoring')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
<style>
    a {
        margin: 10px;
    }


    select,
    input[type="text"] {
        width: 200px;
        padding: 8px;
        margin: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button[type="submit"] {
        background-color: #007BFF;
        color: #fff;
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 16px;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>

@endpush

@section('main')
<div class="row">
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Arsip</h1>
            </div>
        </section>
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close"
                    data-dismiss="alert">
                    <span>&times;</span>
                </button>
                {{ session('error') }}
            </div>
        </div>
        @endif
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('arsip.cari') }}" class="form-inline">
                    @csrf
                    <div class="form-group">
                        <label for="extension">Filter berdasarkan nama file:</label>
                        <input type="text" name="search" id="search" placeholder="Cari">
                        <button type="submit">Cari <i class="fa-solid fa-magnifying-glass"></i></button>
                        <button type="submit" name="search" value="semua">Tampilkan Semua</button>
                    </div>
                </form>

                @if (@isset($filteredFiles))

                <table class="table table-striped-columns mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($filteredFiles as $directory)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ basename($directory) }}</td>
                            <td>
                                @if (Storage::exists($directory))
                                <a href="{{ Storage::url($directory) }}" download><i
                                        class="fa-solid fa-file-arrow-down"></i><span> Download</span></a>
                                @else
                                File not found
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
                @endif

            </div>
        </div>
    </div>
</div>




@endsection

@push('scripts')
@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
<script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
@endpush