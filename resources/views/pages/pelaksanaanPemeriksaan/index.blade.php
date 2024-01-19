@extends('layout.main')

@section('title', 'Pelaksanaan Pemeriksaan')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pelaksanaan Pemeriksaan </h1>
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
    <form>
        <div class="card col-12 mt-1">
            <div class="card-header">
                <div class="card-header-form">
                    <div class="input-group align-items-center">
                        <select name="periode_pemeriksaan" id="" class="form-control">
                            @foreach ($perencanaan as $data)
                            <option value="{{ $data->tanggal_awal }}" {{ Request::get('periode_pemeriksaan')==$data->
                                tanggal_awal ? 'selected' : ('') }}>
                                {{ \Carbon\Carbon::parse($data->tanggal_awal)->isoFormat('D MMMM Y') }}
                            </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if (request()->has('periode_pemeriksaan') && $badanUsaha->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Badan Usaha</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($badanUsaha as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_badan_usaha }}</td>
                                <td>{{ $data->jenis_pemeriksaan }}</td>
                                <td>
                                    <a href="{{ route('kertas-kerja.create', $data->id) }}"
                                        class="btn btn-success">Kertas Kerja <i class="fas fa-file-excel"></i></a>
                                    <a href="{{ route('berita-acara.create', $data->id) }}"
                                        class="btn btn-primary">Berita Acara <i class="fas fa-file-pdf"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection