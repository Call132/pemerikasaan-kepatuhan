@extends('layout.main-admin')

@section('title', 'Dashboard')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard Admin</h1>
        </div>
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card-body">
            <div class="table-responsive" style="text-align:center;">
                <table class="table table-striped-columns mb-0 ">
                    <thead style="background-color: #00B0F0;">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Perencanaan</th>
                            <th>Daftar Badan Usaha</th>
                            <th>Aksi</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        @if ($latestPerencanaan->count() > 0)

                        {{-- @dd($latestPerencanaan, $badanUsahaDiajukan) --}}




                        <tr>
                            <td>1</td>
                            <td>{{ $latestPerencanaan->start_date }}</td>
                            <td>
                                <a href="#" class=" lihat-detail" data-toggle="modal"
                                    data-target="#modalDetilPerencanaan"
                                    data-perencanaan-id="{{ $latestPerencanaan->id }}">
                                    lihat detail
                                </a>

                            </td>
                            <td class="button-cell">
                                <form method="POST" action="{{ route('admin.approve', $latestPerencanaan->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Setujui</button>
                                </form>

                                <form method="POST" action="{{ route('admin.reject', $latestPerencanaan->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                </form>
                            </td>

                            <td>
                                <textarea name="note" class="form-control" id="note" rows="3"></textarea>
                            </td>
                        </tr>

                        @else
                        <div class="table-responsive mx-auto">
                            <table class="table table-striped">
                                <tr>
                                    <td colspan="11">Belum perencanaan yang diajukan!!
                                    </td>
                                </tr>
                            </table>
                        </div>
                        @endif
                    </tbody>

                </table>
            </div>
        </div>

    </section>
</div>
<div class="modal fade" id="modalDetilPerencanaan" tabindex="-1" role="dialog"
    aria-labelledby="modalDetilPerencanaanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Badan Usaha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @if ($badanUsaha->count() > 0)
                @php
                $totalTunggakan = 0;
                @endphp
                <div class="table-responsive">

                    <table class="table table-bordered ">
                        <thead style="background-color: #00B0F0; ">
                            <tr>
                                <th>No</th>
                                <th>Nama Badan Usaha</th>
                                <th>Kode Badan Usaha</th>
                                <th>Alamat</th>
                                <th>Kota/Kab</th>
                                <th>Jenis Ketidakpatuhan</th>
                                <th>Tanggal Terakhir Bayar</th>
                                <th>Jumlah Tunggakan</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>Jadwal Pemeriksaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($badanUsaha as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_badan_usaha }}</td>
                                <td>{{ $data->kode_badan_usaha }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td>{{ $data->kota_kab }}</td>
                                <td>{{ $data->jenis_ketidakpatuhan }}</td>
                                <td>{{ $data->tanggal_terakhir_bayar }}</td>
                                <td>Rp.{{ number_format($data->jumlah_tunggakan, 2, ',', '.') }}</td>
                                <td>{{ $data->jenis_pemeriksaan }}</td>
                                <td>{{ $data->jadwal_pemeriksaan }}</td>
                            </tr>
                            @php
                            // Menambahkan jumlah tunggakan ke total
                            $totalTunggakan += $data->jumlah_tunggakan;
                            @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="totall">
                                <td colspan="7" class="totall text-center">Total</td>
                                <td colspan="4" class="">
                                    Rp{{ number_format($totalTunggakan, 2, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal Detil Perencanaan -->
{{-- <div class="modal fade" id="modalDetilPerencanaan" tabindex="-1" role="dialog"
    aria-labelledby="modalDetilPerencanaanLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetilPerencanaanLabel">Detil Badan Usaha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div> --}}


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
    $(document).ready(function() {
            $('.lihat-detail').on('click', function() {
    var perencanaanId = $(this).data('perencanaan-id');
    $.ajax({
        url: '/get-detil-badan-usaha/' + perencanaanId,
        method: 'GET',
        success: function(data) {
            $('#detilBadanUsaha').html(data);
            $('#modalDetilPerencanaan').modal('show');
        },
    });
});

        });
</script>


<!-- Page Specific JS File -->
<script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush