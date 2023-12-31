@extends('layout.main')
@section('title', 'Kertas Kerja Pemeriksaan')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
<style>
    a {
        margin: 10px;
    }

    form {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    select,
    input[type="text"] {
        width: 200px;
        padding: 8px;
        margin: 5px;
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
                <h1>Pelaksanaan Pemeriksaan</h1>
            </div>
        </section>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <p class="card-text">
                    <div class="col-md-100">
                        <div class="col-md-100">
                            @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                        </div>
                        </p>
                    </div>
                    <form method="POST" action="{{ route('kertas-kerja.cari') }}">
                        @csrf
                        <div class="form-group">


                            <select name="periode_pemeriksaan" id="periode_pemeriksaan">
                                <option value="">Periode Pemeriksaan</option>

                                @foreach ($perencanaan as $data)
                                <option value="{{ \Carbon\Carbon::parse($data->start_date)->isoFormat('YYYY-MM-DD') }}"
                                    {{-- @if ($data->start_date ==
                                    old('periode_pemeriksaan')) selected @endi> --}}
                                    {{ old('periode_pemeriksaan') === $data->start_date ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($data->start_date)->isoFormat('D MMMM Y') }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="kategori" id="kategori">
                                <option value="">Jenis Pemeriksaan</option>
                                <option value="kantor" {{ old('kategori')=='kantor' ? 'selected' : '' }}>Kantor
                                </option>
                                <option value="lapangan" {{ old('kategori')=='lapangan' ? 'selected' : '' }}>Lapangan
                                </option>
                                <!-- Tambahkan opsi kategori lain sesuai kebutuhan -->
                            </select>
                            <button type="submit">Cari <i class="fa-solid fa-magnifying-glass"></i></button>

                        </div>

                    </form>
                    @if (request()->has('periode_pemeriksaan') && request()->has('kategori') &&
                    $badanUsaha->isNotEmpty())

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Badan Usaha</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>Buat Surat</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            @foreach ($badanUsaha as $index => $bu)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $bu->nama_badan_usaha }}</td>
                                <td>{{ $bu->jenis_pemeriksaan }}</td>

                                <td>
                                    @if ($bu->jenis_pemeriksaan == 'Lapangan')
                                    <a href="{{ route('kertas-kerja.form', ['id' => $bu->id]) }}">
                                        <i class="fa-solid fa-file-export }}"></i> Kertas Kerja</a>
                                    <a href="{{ route('bapket.form', ['id' => $bu->id]) }}"><i
                                            class="fa-solid fa-file-export"></i>Berita Acara Pemeriksaan</a>
                                    @elseif ($bu->jenis_pemeriksaan == 'Kantor')
                                    <a href="{{ route('kertas-kerja.form', ['id' => $bu->id]) }}">
                                        <i class="fa-solid fa-file-export"></i>Kertas Kerja
                                    </a>
                                    <a href="{{ route('bapket.form', ['id' => $bu->id]) }}">
                                        <i class="fa-solid fa-file-export"></i>Berita Acara Pemeriksaan
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @elseif (!request()->has('periode_pemeriksaan'))
                    <p>Tidak ada hasil yang sesuai dengan kategori.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endsection
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