<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Panggilan Pemeriksaan Lapangan BPJS</title>
    <style>
        /* Gaya CSS untuk tampilan surat */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
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
            font-size: 16px;
        }

        .content p {
            text-align: justify;
        }

        .section {
            margin-top: 20px;
        }

        .section h3 {
            font-size: 16px;
        }

        .section h4 {
            font-size: 16px;
        }

        .section .form-group {
            margin-bottom: 10px;
        }

        .section label {
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            text-align: left;
            font-size: 10px;
        }

        /* CSS untuk menempatkan teks di sebelah kanan halaman */
        .right-aligned-text {
            text-align: right;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        /* CSS untuk menggeser teks ke kanan */
        .indent-text {
            text-indent: 35px;
        }

        .label {
            display: inline-block;
            min-width: 143px;
        }

        .form-group p {
            margin-bottom: -1.0em;
        }

        /* CSS untuk halaman pertama */
        .page1 {
            page-break-before: auto;
        }

        /* CSS untuk halaman kedua */
        .page2 {
            page-break-before: always;
        }

        .label1 {
            display: inline-block;
            min-width: 70px;
        }

        .label2 {
            display: inline-block;
            min-width: 200px;
        }
    </style>
</head>

<body>
    <div class="content page1">
        <div class="right-aligned-text">Gorontalo, {{
            \Carbon\Carbon::parse($sppl->tanggal_surat)->locale('id')->isoFormat('D MMMM Y') }}</div>
        <span class="label1">Nomor</span>: {{ $sppl->nomor_sppl }} <br>
        <span class="label1">Lampiran</span>: Satu Berkas <br>
        <span class="label1">Hal</span>: Pemberitahuan Pemeriksaan Lapangan <br>
        <span class="label1">Sifat</span>: <strong>RAHASIA</strong>
        <p>
            Yth. Pimpinan {{ $badanUsaha->nama_badan_usaha }}<br>
            {{ $badanUsaha->alamat }}<br>
            di Tempat
        </p>
        <p class="indent-text">
            Sesuai dengan Pasal 11 huruf c Undang-Undang Republik Indonesia Nomor 24 Tahun 2011 Tentang Badan
            Penyelenggara Jaminan Sosial, BPJS Kesehatan diberikan kewenangan untuk melakukan Pengawasan dan
            Pemeriksaan Kepatuhan dalam Penyelenggaran Jaminan Kesehatan, maka bersama ini kami sampaikan, BPJS
            Kesehatan Cabang Gorontalo akan melakukan Pemeriksaan terhadap
            <strong>{{ $badanUsaha->nama_badan_usaha }}</strong> dalam hal
            <strong>kewajiban Pembayaran Iuran</strong>.
        </p>
        <p class="indent-text">
            Pemeriksaan akan dilaksanakan pada
            <strong>{{ \Carbon\Carbon::parse($badanUsaha->jadwal_pemeriksaan)->locale('id')->isoFormat('dddd, D MMMM Y')
                }}</strong>
            oleh Petugas Pemeriksa BPJS Kesehatan yang diberikan Surat Perintah Tugas. Untuk kelancaran jalannya
            Pemeriksaan, diminta agar Bapak/Ibu dapat menyediakan dan memberikan buku atau catatan dan dokumen
            terlampir yang diperlukan pada saat pemeriksaan dilaksanakan. Informasi lebih lanjut melalui
            ({{ $sppl->noHp }}) ({{ $sppl->nama }}).
        </p>
        <p class="indent-text">
            Demikian untuk menjadi perhatian Bapak/Ibu, atas kerjasamanya diucapkan terimakasih.
        </p>
    </div>
    <div class="signature-container" style="text-align: right;">
        <div class="signature">
            <p style="margin-right: 65px;">Kepala Cabang</p>
            <br>
            <p style="margin-right: 110px;">$$</p><br>
            <p style="margin-right: 55px;">{{ $employee }}</p>
        </div>
        <div class="footer">
            <p>RL/ta/PP.01.02</p>
        </div>
    </div>
    <div class="page-break"></div>
    <div class="content page2">
        <div class="section">
            <p style="text-align: left;">Lampiran :</p>
            <h2 style="text-align: center;">Daftar Permintaan/Peminjaman Buku<br>Catatan atau Dokumen</h2>
            <div class="form-group">
                <p><span class="label2">Nama Pemberi Kerja</span>: {{ $badanUsaha->nama_badan_usaha }}</p>
                <p><span class="label2">Kode Entitas</span>: {{ $badanUsaha->kode_badan_usaha }}</p>
                <p><span class="label2">Alamat</span>: {{ $badanUsaha->alamat }}</p>
            </div>
        </div>
        <br>
        <table style="width:100%; border-collapse: collapse;">
            <thead style="text-align: center; height: 50px;">
                <tr>
                    <th style="border: 1px solid black;">No.</th>
                    <th style="border: 1px solid black;">Nama Buku, Catatan atau Dokumen</th>
                    <th style="border: 1px solid black;">Keterangan</th>
                </tr>
            </thead>
            <tbody style="text-align: left; height: 200px;">
                <tr>
                    <td style="border: 1px solid black;">1</td>
                    <td style="border: 1px solid black;">Data pekerja (bulan terakhir)</td>
                    <td style="border: 1px solid black;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">2</td>
                    <td style="border: 1px solid black;">Data gaji pekerja (bulan terakhir)</td>
                    <td style="border: 1px solid black;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">3</td>
                    <td style="border: 1px solid black;">Slip gaji pekerja (bulan terakhir)</td>
                    <td style="border: 1px solid black;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">4</td>
                    <td style="border: 1px solid black;">Data kepesertaan Jaminan Ketenagakerjaan (Formulir F2A)</td>
                    <td style="border: 1px solid black;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">5</td>
                    <td style="border: 1px solid black;">Cap Perusahaan (Jika Ada)</td>
                    <td style="border: 1px solid black;"></td>
                </tr>
            </tbody>
        </table>
        <p class="indent-text">
            Demi kelancaran Pemeriksaan, agar Seluruh data/informasi/dokumen yang telah disebutkan di atas
            dipersiapkan dan sudah kami terima saat pelaksanaan Pemeriksaan.
        </p>
    </div>
    <div class="footer">
        <p>RL/ta/PP.01.02</p>
    </div>
</body>

</html>