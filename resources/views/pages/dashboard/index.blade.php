@extends('layout.main')

@section('title', 'Dashboard')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
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
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">

                    <div class="card-header">
                        <h4>PERENCANAAN PEMERIKSAAN</h4>

                        @if (optional($perencanaan)->count() > 0)
                        @if ($perencanaan->status === 'Diajukan')
                        <span class="badge badge-danger">Belum Diapprove</span>
                        @elseif ($perencanaan->status === 'approved')
                        <span class="badge badge-success">Approved</span>
                        @endif
                        @endif
                    </div>
                    @php
                    $totalTunggakan = 0;
                    @endphp
                    @if (optional($perencanaan)->count() > 0)
                    @if ($badanUsaha->count() > 0)
                    <div class="card-body p-2">
                        <div class="table-responsive">
                            <table class="table table-striped-columns px-2 ">
                                <thead>
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
                                        <th>Aksi
                                        </th>
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
                                        <td>Rp{{ number_format(floatval(str_replace(['Rp ', '.'], '',
                                            $data->jumlah_tunggakan)), 2, ',', '.') }}
                                        </td>

                                        <td>{{ $data->jenis_pemeriksaan }}</td>
                                        <td>{{ $data->jadwal_pemeriksaan }}</td>
                                        <td>
                                            <div class="btn-group " role="group">
                                                <a href="{{ route('badanusaha.edit', $data->id) }}"
                                                    class="btn btn-warning"><i
                                                        class="fa-solid fa-pen-to-square"></i></a>
                                                <form action="{{ route('delete.badanusaha', $data->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger ml-2"><i
                                                            class="fa-solid fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                    $totalTunggakan += floatval(str_replace(['Rp ', '.'], '', $data->jumlah_tunggakan));
                                    @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <a href="{{ route('badanusaha.create', $perencanaan->id) }}"
                                        class="btn btn-primary mx-2 mb-2">Tambah <i class="fa-solid fa-plus"></i></a>
                                    <a href="{{ route('badanusaha.export') }}" class="btn btn-success mx-2 mb-2">xlsx <i
                                            class="fa-solid fa-file-excel"></i></a>
                                    <tr class="totall">
                                        <td colspan="7" class="totall text-center">Total</td>
                                        <td colspan="4" class="">Rp
                                            {{ number_format($totalTunggakan, 2, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="card-body p-0">
                        <div class="table-responsive">

                            <table class="table table-striped-columns mb-0 ">
                                <thead>
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
                                        <th><a href="{{ route('badanusaha.create', $perencanaan->id) }}"
                                                class="btn btn-primary m-auto">Tambah</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="11" class="text-center">Data Badan Usaha Belum
                                            Ditambahkan</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <a href="{{ route('badanusaha.create', $perencanaan->id) }}"
                                        class="btn btn-primary m-auto"><i class="fa-solid fa-plus"></i></a>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="table-responsive mx-auto">
                        <table class="table table-striped">
                            <tr>
                                <td colspan="11">Belum ada data perencanaan pemeriksaan! <a
                                        href="{{ url('perencanaan') }}" class="btn btn-primary">Buat
                                        Perencanaan</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')

<script>
    document.addEventListener("DOMContentLoaded", function() {
            var startDateInput = document.getElementById("start_date");
            var endDateInput = document.getElementById("end_date");

            // Fungsi untuk menghitung tanggal akhir berdasarkan tanggal awal
            function updateEndDate() {
                var startDate = new Date(startDateInput.value);
                var endDate = new Date(startDate);
                endDate.setDate(startDate.getDate() + 14);

                // Format tanggal ke dalam "YYYY-MM-DD" untuk input
                var formattedEndDate = endDate.toISOString().split('T')[0];
                endDateInput.value = formattedEndDate;
            }

            // Panggil fungsi saat tanggal awal berubah
            startDateInput.addEventListener("change", updateEndDate);

            // Inisialisasi tanggal awal dan tanggal akhir saat halaman dimuat
            updateEndDate();
        });
</script>

@endpush