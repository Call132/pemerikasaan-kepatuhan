@extends('layout.main')

@section('title', 'Monitoring')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Monitoring</h1>
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
    <div class="card col-12 mt-1">
        <div class="card-header">
            <div class="card-header-form">
                <form>
                    <div class="input-group align-items-center">
                        <select name="periode_pemeriksaan" id="periode_pemeriksaan" class="form-control rounded-right">
                            @foreach ($perencanaan as $data)
                            <option value="{{ $data->tanggal_awal }}" {{ Request::get('periode_pemeriksaan')==$data->
                                tanggal_awal ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($data->tanggal_awal)->isoFormat('D MMMM Y') }}
                            </option>
                            @endforeach
                        </select>
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-primary rounded-left"><i
                                    class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            @if (isset($selectedPerencanaan) && $badanUsaha->isNotEmpty())
            <form action="{{ route('monitoring.export' , $selectedPerencanaan->id) }}" method="post">
                @csrf
                <div class="table-responsive">
                    @php
                    $totalTunggakan = 0;
                    $totalBayar = 0;
                    @endphp
                    <table class="table table-striped-columns mb-0 ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pemeriksaan</th>
                                <th>Nama Badan Usaha</th>
                                <th>Kode Badan Usaha</th>
                                <th>Alamat</th>
                                <th>Tanggal Terakhir Bayar</th>
                                <th>Jumlah Bulan Menunggak</th>
                                <th>Jumlah Tunggakan</th>
                                <th>Tanggal Bayar</th>
                                <th>Jumlah Bayar</th>
                                <th>Hasil Pemeriksaan</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($badanUsaha as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->jadwal_pemeriksaan }}</td>
                                <td>{{ $data->nama_badan_usaha }}</td>
                                <td>{{ $data->kode_badan_usaha }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td>{{ $data->tanggal_terakhir_bayar }}</td>
                                <td>{{ $data->jumlah_bulan_menunggak }} (Bulan)</td>
                                <td>Rp.{{ number_format($data->jumlah_tunggakan, 2, ',', '.') }}</td>
                                <td>{{ $data->tanggal_bayar }}</td>
                                <td>Rp.{{ number_format($data->jumlah_bayar), 2, ',', '.' }}</td>
                                <td>{{ $data->hasil_pemeriksaan }}</td>
                                <td>
                                    {{ number_format($data->jumlah_tunggakan != 0 ? ($data->jumlah_bayar /
                                    $data->jumlah_tunggakan)
                                    * 100 : 'N/A', 0) }}%
                                </td>
                            </tr>
                            @php
                            // Menambahkan jumlah tunggakan ke total
                            $totalTunggakan += $data->jumlah_tunggakan;
                            $totalBayar += $data->jumlah_bayar;
                            @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="totall text-center">
                                <td colspan="7" class="totall ">Total</td>
                                <td colspan="2">
                                    Rp. {{ number_format($totalTunggakan, 2, ',', '.') }}
                                </td>
                                <td colspan="2">
                                    Rp. {{ number_format($totalBayar, 2, ',', '.') }}
                                </td>
                                <td colspan="1">
                                    {{ number_format($totalTunggakan != 0 ? ($totalBayar / $totalTunggakan) * 100 :
                                    'N/A', 0) }}%
                                </td>
                            </tr>
                            <button type="submit" class="btn btn-primary" style="margin-bottom: 10px">Cetak <i
                                    class="fa-solid fa-print"></i></button>
                        </tfoot>
                    </table>
                </div>
            </form>
            @else
            <div class="empty-state" data-height="400">
                <div class="empty-state-icon">
                    <i class="fas fa-question"></i>
                </div>
                <h2>Tidak ada data ditemukan untuk periode pemeriksaan yang dipilih</h2>
                <p class="lead">
                    Maaf, kami tidak menemukan data untuk periode pemeriksaan yang Anda pilih. Silakan coba periode
                    pemeriksaan lain atau buat setidaknya 1 entri.
                </p>
            </div>
            @endif
        </div>


    </div>
</div>
@endsection