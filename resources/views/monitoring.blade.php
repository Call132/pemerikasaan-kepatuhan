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
                <h1>Monitoring</h1>
            </div>
        </section>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('monitoring.cari') }}">
                    @csrf
                    <div class="form-group">
                        <select name="periode_pemeriksaan" id="periode_pemeriksaan">
                            <option value="">Periode Pemeriksaan</option>
                            @foreach ($perencanaan as $data)
                            <option value="{{ \Carbon\Carbon::parse($data->start_date)->isoFormat('YYYY-MM-DD') }}" {{
                                old('periode_pemeriksaan')===$data->start_date ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($data->start_date)->isoFormat('D MMMM Y') }}
                            </option>
                            @endforeach
                        </select>
                        <button type="submit">Cari <i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
                @if (request()->has('periode_pemeriksaan'))
                    @include('monitoring-data')
                    
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