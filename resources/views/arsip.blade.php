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
                <button class="close" data-dismiss="alert">
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
                        <select name="search" id="search" placeholder="Cari">
                            <option value="Perencanaan">Perencanaan</option>
                            <option value="Surat Perintah Tugas">Surat Perintah Tugas</option>
                            <option value="Program Realisasi Pemeriksaan">Program Realisasi Pemeriksaan</option>
                            <option value="Kertas Kerja Pemeriksaan">Kertas Kerja Pemeriksaan</option>
                            <option value="Berita Acara Pemeriksaan">Berita Acara Pemeriksaan</option>
                            <option value="Laporan Hasil Pemeriksaan Sementara">Laporan Hasil Pemeriksaan Sementara
                            </option>
                            <option value="Laporan Hasil Pemeriksaan Akhir">Laporan Hasil Pemeriksaan Akhir</option>
                            <option value="Surat Pemberitahuan Hasil Pemeriksaan ">Surat Pemberitahuan Hasil Pemeriksaan
                            </option>
                        </select>
                        <button type="submit">Cari <i class="fa-solid fa-magnifying-glass"></i></button>
                        <button type="submit" name="search" value="semua">Tampilkan Semua</button>
                    </div>
                </form>

                @if (@isset($surat))

                <table class="table table-striped-columns mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>File</th>
                            <th>Jenis Surat</th>
                            <th>Tanggal Surat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">

                        @foreach ($surat as $directory)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $directory->nomor_surat }}</td>
                            <td>{{ $directory->jenis_surat }}</td>
                            <td>{{ \Carbon\Carbon::parse($directory->created_at)->isoFormat('D MMMM Y') }}</td>

                            <td>

                                @if (url($directory->file_path))
                                <a href="{{ url($directory->file_path) }}" download><i
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
                <div class="card-body">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            @if ($surat->currentPage() > 1)
                            <li class="page-item"><a class="page-link"
                                    href="{{ $surat->previousPageUrl() }}">Previous</a></li>
                            @endif

                            @for ($i = 1; $i <= $surat->lastPage(); $i++)
                                <li class="page-item {{ ($i == $surat->currentPage()) ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $surat->url($i) }}">{{ $i }}</a>
                                </li>
                                @endfor

                                @if ($surat->currentPage() < $surat->lastPage())
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $surat->nextPageUrl() }}">Next</a></li>
                                    @endif
                        </ul>
                    </nav>
                </div>
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