<form action="{{ route('monitoring.export' , ['id' => $p->id]) }}" method="post">
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
                    <td>{{ $data->jumlah_tunggakan != 0 ? ($data->jumlah_bayar / $data->jumlah_tunggakan) * 100 . '%' :
                        'N/A' }}</td>
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
                        {{ $totalTunggakan != 0 ? ($totalBayar / $totalTunggakan) * 100 .
                        '%' : 'N/A' }}
                    </td>

                </tr>
                <button type="submit" class="btn btn-primary" style="margin-bottom: 10px">Cetak <i
                        class="fa-solid fa-print"></i></button>
            </tfoot>
        </table>
    </div>
</form>