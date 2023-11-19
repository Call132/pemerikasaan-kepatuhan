@extends('layout.main')

@section('title', 'Surat Pemberitahuan Hasil Pemeriksaan')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1> Surat Pemberitahuan Hasil Pemeriksaan {{ $badanUsaha->nama_badan_usaha }}</h1>
        </div>
    </section>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-text">
                    <div class="col-md-100">
                        <div class="col-md-100">
                            @if (session('error'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <form action="{{ route('sphp.store') }}" method="POST" id="myForm">
                                @csrf
                                <input type="hidden" name="badan_usaha_id" value="{{ $badanUsaha->id }}">
                                <input type="hidden" name="tgl_sphp" value="{{ now()->format('Y-m-d') }}">
                                <div class="form-group">
                                    <label for="no_sphp">Nomor Surat Pemberitahuan Hasil Pemeriksaan</label>
                                    <input type="text" class="form-control" id="no_sphp" name="no_sphp">
                                </div>
                                <div class="form-group">
                                    <h5>Uraian Hasil</h5>
                                </div>
                                <div class="form-group">
                                    <label for="p-a">Point a.</label>
                                    <textarea type="text" class="form-control" id="p-a" name="p-a"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="p-b">Point b.</label>
                                    <textarea type="text" class="form-control" id="p-b" name="p-b"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="p-c">Point c.</label>
                                    <textarea type="text" class="form-control" id="p-c" name="p-c"></textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit" onclick="submitForm()" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
    <script>
        function submitForm() {
        document.getElementById('myForm').addEventListener('submit', function() {
            setTimeout(function() {
                window.location.href = '/sphp';
            }, 3000); // Redirect after 1 second (adjust the delay as needed)
        });
    }
    </script>


    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
    @endpush