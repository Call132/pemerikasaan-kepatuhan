<section>
    <div class="card-body">
        <div class="table-responsive" style="text-align:center;">
            <table class="table table-striped-columns mb-0 ">
                <thead style="background-color: #00B0F0;">
                    <tr>
                        <th>No</th>
                        <th>Periode Perencanaan</th>
                        <th>Daftar Badan Usaha</th>
                        <th colspan="2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    @if ($perencanaan !== null)
                    <tr>
                        <td>1</td>
                        <td>{{ \Carbon\Carbon::parse($perencanaan->tanggal_awal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($perencanaan->tanggal_akhir)->format('d M Y') }}</td>
                        <td>
                            <a href="#" class=" lihat-detail" data-toggle="modal" data-target="#modalDetilPerencanaan"
                                data-perencanaan-id="{{ $perencanaan->id }}">
                                lihat detail
                            </a>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('approve', $perencanaan->id) }}">
                                @csrf
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-success">Setujui</button>
                                    <input type="text" class="form-control ml-2" id="catatan" name="catatan"
                                        placeholder="Catatan">
                                </div>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('reject', $perencanaan->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger ml-2">Tolak</button>
                            </form>
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

                @if ($badanUsaha !== null)
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