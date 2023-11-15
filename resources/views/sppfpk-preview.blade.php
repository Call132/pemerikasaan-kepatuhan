<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Panggilan Pemeriksaan Kantor BPJS</title>
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
            font-size: 12px;
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
            /* Sesuaikan dengan posisi vertikal yang diinginkan */
            right: 20px;
            /* Sesuaikan dengan posisi horizontal yang diinginkan */
        }

        /* CSS untuk menggeser teks ke kanan */
        .indent-text {
            text-indent: 35px;
            /* Sesuaikan jumlah indentasi yang diinginkan di sini */
        }

        .label {
            display: inline-block;
            min-width: 143px;
            /* Sesuaikan dengan lebar minimum yang Anda inginkan */
        }

        .form-group p {
            margin-bottom: -1.0em;
            /* Sesuaikan dengan jarak yang diinginkan, misalnya 1.0em */
        }

        /* CSS untuk halaman pertama */
        .page1 {
            page-break-before: auto;
            /* Jangan menggunakan page break di halaman pertama */
        }

        /* CSS untuk halaman kedua */
        .page2 {
            page-break-before: always;
            /* Beri page break sebelum halaman kedua */
        }

        .label1 {
            display: inline-block;
            min-width: 70px;
            /* Sesuaikan dengan lebar minimum yang Anda inginkan */
        }

        .form-group p {
            margin-bottom: -1.0em;
            /* Sesuaikan dengan jarak yang diinginkan, misalnya 1.0em */
        }

        .label2 {
            display: inline-block;
            min-width: 200px;
            /* Sesuaikan dengan lebar minimum yang Anda inginkan */
        }

        .form-group p {
            margin-bottom: -1.0em;
            /* Sesuaikan dengan jarak yang diinginkan, misalnya 1.0em */
        }
    </style>
</head>

<body>
    <div class="content page1" style="font-size: 16px;">
        <p>
        <div class="right-aligned-text">Gorontalo, {{ \Carbon\Carbon::parse($sppfpk->tanggal_surat)->locale('id')->isoFormat('D MMMM Y')}}</div>
        <span class="label1">Nomor</span> : {{ $sppfpk->nomor_sppfpk }} <br>
        <span class="label1">Lampiran</span> : Satu Berkas <br>
        <span class="label1">Hal</span> : Panggilan Pemeriksaan Final
        </p>
        <p>
            Yth. Pimpinan {{ $badanUsaha->nama_badan_usaha }}<br>
            {{ $badanUsaha->alamat }}<br>
            di <br> Tempat
        </p>
        <p class="indent-text" style="font-size: 16px; margin-bottom: -1.0em;">
            Sesuai dengan Pasal 11 huruf c Undang-Undang Republik Indonesia Nomor 24 Tahun 2011 Tentang Badan
            Penyelenggara Jaminan Sosial, BPJS Kesehatan berwenang melakukan pemeriksaan atas kepatuhan Pemberi Kerja
            pada Program Jaminan Kesehatan dalam hal kewajiban <strong>Pembayaran Iuran</strong>.
        </p>
     
        <p class="indent-text" style="font-size: 16px; margin-bottom: 1.0em;">
            BPJS Kesehatan Cabang Gorontalo telah mengirimkan surat Nomor: {{ $sppk->nomor_sppk }} tanggal {{ \Carbon\Carbon::parse($sppk->tanggal_pemeriksaan)->locale('id')->isoFormat('D MMMM Y') }}
            tentang Panggilan Pemeriksaan, Bapak/Ibu sebagai Pimpinan perusahaan ataupun yang mewakili belum memenuhi
            panggilan pemeriksaan sesuai waktu yang telah ditentukan. Maka bersama surat ini kami sampaikan Panggilan
            Pemeriksaan Final pada:
        </p>

        <div class="section">
            <div class="form-group" style="font-size: 16px;">
                <p><span class="label">Hari/Tanggal</span>: {{ \Carbon\Carbon::parse($badanUsaha->jadwal_pemeriksaan)->locale('id')->isoFormat('D MMMM Y') }} </p>
                <p><span class="label">Waktu</span>: {{ $sppfpk->waktu }} Wita</p>
                <p><span class="label">Tempat</span>: Kantor BPJS Kesehatan Cabang Gorontalo</p>
                <p><span class="label">Agenda</span>: Pemeriksaan Kepatuhan</p>
            </div>
        </div>
        <br>
        <div class="section">
            <div class="form-group" style="font-size: 16px;">
                <p>Bertemu dengan Petugas Pemeriksa</p>
                <p><span class="label">Nama</span>: {{ $namaTimPemeriksa }}</p>
                <p><span class="label">NPP</span>: {{ $nppTimPemeriksa }}</p>
            </div>
        </div>
        <br>
        <p class="indent-text" style="font-size: 16px;">
            Dalam hal Bapak/Ibu berhalangan hadir, yang mewakili wajib membawa surat kuasa yang telah ditandatangani.
        </p>
        <p class="indent-text" style="font-size: 16px;">
            Demikian untuk menjadi perhatian Bapak/Ibu, atas kerjasamanya diucapkan terimakasih.
        </p>
    </div>
    <br>
    <div class="signature-container" style="text-align: right;">
        <div class="signature">
            <p style="margin-right: 65px;">Kepala Cabang</p>
            <br><br><br>
            <p style="margin-right: 55px;">{{ $employee }}</p>
        </div>
        <div class="footer">
            <p>RL/ta/PP.01.02</p>
        </div>

        <div class="content page2" style="font-size: 16px;">
            <div class="section">
                <p style="text-align: left;">Lampiran :</p>
                <h2 style="text-align: center;">Daftar Permintaan/Peminjaman Buku<br>Catatan atau Dokumen</h2>
                <div class="form-group" style="font-size: 16px;">
                    <p><span class="label2">Nama Pemberi Kerja</span>: {{ $badanUsaha->nama_badan_usaha }}</p>
                    <p><span class="label2">Kode Entitas</span>: {{ $badanUsaha->kode_badan_usaha }}</p>
                    <p><span class="label2">Alamat</span>: {{ $badanUsaha->alamat }}</p>
                </div>
            </div>
        </div>
        <br>
        <table style="width:100%; border-collapse: collapse;">
            <thead style="text-align: center; height :50px;">
                <tr>
                    <th style="border: 1px solid black;">No.</th>
                    <th style="border: 1px solid black;">Nama Buku, Catatan atau Dokumen</th>
                    <th style="border: 1px solid black;">Keterangan</th>
                </tr>
            </thead>
            <tbody style="text-align: left; height :200px;">
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
        <br>
        <p class="indent-text" style="font-size: 16px; text-align:left">
            Demi kelancaran Pemeriksaan, agar Seluruh data/informasi/dokumen yang telah disebutkan diatas dipersiapkan
            dan sudah kami terima saat pelaksanaan Pemeriksaan.
        </p>
</body>

</html>
