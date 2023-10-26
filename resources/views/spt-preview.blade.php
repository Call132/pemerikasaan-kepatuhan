<!DOCTYPE html>
<html>

<head>
    <title>SURAT PERINTAH TUGAS</title>
    <style>
        /* Gaya CSS untuk tampilan PDF */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        @page {
            size: portrait;
        }

        .container {
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;

        }

        .header h2 {
            margin: 0;
            padding: 0;
        }

        .content {
            margin-top: 20px;
            font-size: 12px;
        }

        .petugas-pemeriksa,
        .pendamping {
            margin-top: 20px;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            margin-right: 20px;
            text-align: left;
            font-size: 9px;
        }

        .label {
            display: inline-block;
            min-width: 200px;
            /* Sesuaikan dengan lebar minimum yang Anda inginkan */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        @media print {
            .page-break {
                page-break-before: always;
            }

            .page2 {
                page-break-before: always;
                /* Beri page break sebelum halaman kedua */
            }

        }


        .table th,
        .table td {
            border: 1px solid #000;
            padding: 4px;
        }

        .table th {
            background-color: #00B0F0;
            color: white;
            font-size: 8px;
            text-align: center;
        }

        .table td {
            font-size: 9px;
        }

        .table tfoot {
            background-color: #92D050;
            color: white;
        }

        .indent-first-line {
            text-indent: 20px;
            /* Sesuaikan nilai indentasi sesuai keinginan Anda */
            margin: 0;
            /* Untuk menghilangkan margin bawaan */
        }

        .content {
            margin-top: 20px;
            font-size: 12px;
        }

        .content p {
            text-align: justify;
        }

        .page1 {
            page-break-before: auto;
            /* Jangan menggunakan page break di halaman pertama */
        }

        .landscape-page {
            width: 100%;
            height: 100%;
        }
        .page2 {
            page-break-before: always;
            /* Beri page break sebelum halaman kedua */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h4>SURAT PERINTAH TUGAS</h4>
        </div>
        <div class="content page1">
            <h4 class="header">NOMOR: {{ $spt->nomor_spt }}</h4>
            {{-- <p style="text-align: justify;" class="indent-first-line"> --}}
            <p style="text-align: justify;" class="indent-text">
                Berdasarkan Pasal 11 huruf c Undang-Undang Nomor 24 Tahun 2011 Tentang Badan Penyelenggara Jaminan
                Sosial bahwa dalam melaksanakan tugas, BPJS Kesehatan berwenang untuk melakukan pengawasan dan
                pemeriksaan atas kepatuhan Peserta dan Pemberi Kerja dalam memenuhi kewajibannya sesuai dengan ketentuan
                peraturan perundang-undangan jaminan sosial nasional. Kepala Badan Penyelenggara Jaminan Sosial
                Kesehatan Cabang Gorontalo selaku Penanggung Jawab Pemeriksaan, dengan ini menugaskan :
            </p>
            <div class="petugas-pemeriksa">
                <p>Petugas Pemeriksa</p>
                <p><span class="label">Nama</span>: {{ $spt->timPemeriksa->nama }}</p>
                <p><span class="label">NPP</span>: {{ $spt->timPemeriksa->npp }}</p>
            </div>
            <div class="pendamping">
                <p>Petugas Pendamping</p>
                @foreach ($spt->pendamping as $pendamping)
                    <p><span class="label">Nama</span>: {{ $pendamping->nama }}</p>
                    <p><span class="label">NPP</span>: {{ $pendamping->npp }}</p>
                @endforeach
                @foreach ($spt->extPendamping as $extPendamping)
                    <p><span class="label">Nama</span>: {{ $extPendamping->nama }}</p>
                    <p><span class="label">Jabatan</span>: {{ $extPendamping->jabatan }}</p>
                @endforeach
            </div>

            <div class="">
                <p><span class="label">Tanggal Pemeriksaan </span>: {{ $tanggalPemeriksaan }}</p>
                <p><span class="label"> Penugasan </span>: Melakukan pemeriksaan kepatuhan terhadap Badan Usaha sebagai
                    berikut :</p>
            </div>
            <p class="header" style="text-align: justify;">Demikian untuk diketahui dan dilaksanakan sebagaimana
                mestinya.</p>

            <p style="text-align: right; margin-bottom:-8px; margin-right: 5px">Gorontalo, {{ $dateNow }}</p>
            <div class="signature-container" style="text-align: right;">
                <div class="signature">
                    <div style="float: right; text-align: right;">
                        <p style="margin-right: 65px;">Kepala Cabang</p>
                        <br><br><br>
                        <p style="margin-right: 46px;">{{ $employee }}</p>
                    </div>
                </div>
            </div>

            <div class="footer" style="clear: both;">
                <p>RL/ta/PP.01.02</p>
            </div>
        </div>
    </div>


    <div class="page-break"></div>
    <div class="content page2 ">
        <div class="header">
            <h4>Lampiran</h4>
        </div>
        <div class="header">
            <h4>Nomor : {{ $spt->nomor_spt }}</h4>
        </div>
        <div class="card-body p-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    @php
                        $totalTunggakan = 0;
                    @endphp

                    @if ($badanUsahaDiajukan->count() > 0)
                        <table class="table">
                            <thead>

                                {{-- <tr>
                                <th colspan="10" style="font-weight: bold; font-size: 14px; text-align: center; ">Hari, Tanggal Bulan Tahun - Hari, Tanggal Bulan Tahun</th>
                            </tr> --}}
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

                                @foreach ($badanUsahaDiajukan as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->nama_badan_usaha }}</td>
                                        <td>{{ $data->kode_badan_usaha }}</td>
                                        <td>{{ $data->alamat }}</td>
                                        <td>{{ $data->kota_kab }}</td>
                                        <td>{{ $data->jenis_ketidakpatuhan }}</td>
                                        <td>{{ $data->tanggal_terakhir_bayar }}</td>
                                        <td>Rp{{ number_format(floatval(str_replace(['Rp ', '.'], '', $data->jumlah_tunggakan)), 2, ',', '.') }}
                                        </td>
                                        <td>{{ $data->jenis_pemeriksaan }}</td>
                                        <td>{{ $data->jadwal_pemeriksaan }}</td>
                                    </tr>
                                    @php
                                        // Menambahkan jumlah tunggakan ke total
                                        $totalTunggakan += floatval(str_replace(['Rp ', '.'], '', $data->jumlah_tunggakan));
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="totall">
                                    <td colspan="7" class="totall text-center">Total</td>
                                    <td colspan="3" class="">Rp
                                        {{ number_format($totalTunggakan, 2, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="footer" style="clear: both;">
                            <p>RL/ta/PP.01.02</p>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="11" class="text-center">Data Badan Usaha Belum
                                                Ditambahkan</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>




</body>


</html>
