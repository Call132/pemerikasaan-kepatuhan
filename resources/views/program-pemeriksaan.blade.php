@extends('layout.main')

@section('title', 'Realisasi Pemeriksaan')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Program Realisasi Pemeriksaan</h1>
        </div>
    </section>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Buat Program Pemeriksaan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Badan Usaha</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($badanUsaha as $index => $bu)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $bu->nama_badan_usaha }}</td>
                                <td>
                                    <a href="{{ route('program-pemeriksaan.form', ['id' => $bu->id]) }}"><i class="fa-solid fa-file-export }}"></i> Buat</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection