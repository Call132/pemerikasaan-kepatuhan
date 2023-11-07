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
            font-size: 15px;
        }

        p {
            margin: 0;
            font-size: 16px;
            font-family: 'Arial', sans-serif;
        }

        p.centered {
            text-align: center;
        }

        p.justify {
            text-align: justify;
            text-indent: 1.0cm;
            line-height: normal;
        }

        span {
            font-size: 16px;
            font-family: 'Arial', sans-serif;
        }

        div.centered-text {
            text-align: justify;
            margin-left: 80px;
        }

        /* Gaya untuk mengontrol penampilan halaman */
        @page {
            size: A4 portrait;
            margin: 20mm 10mm;

            /* Margin halaman */
        }

        .page-break {
            page-break-before: always;
        }

        . .label {
            display: inline-block;
            min-width: 180px;
            margin-top: 2px;
            /* Sesuaikan dengan lebar minimum yang Anda inginkan */
        }
    </style>
</head>

<body>



    <div class="content">
        <p class="centered"><strong>FORMULIR</strong></p>
        <p class="centered"><strong>CATATAN HASIL PEMERIKSAAN</strong></p>
        <br>
        <p style="text-indent: 35px; text-align: justify">Pada hari ini {{ \Carbon\Carbon::now()->isoFormat('dddd')
            }} Tanggal {{
            \Carbon\Carbon::now()->isoFormat('D') }} Bulan {{ \Carbon\Carbon::now()->isoFormat('MMMM') }} Tahun Dua
            Ribu Dua Puluh Tiga berdasarkan Surat Perintah Tugas Nomor: {{ $spt->nomor_spt }} tanggal
            {{\Carbon\Carbon::parse($spt->tanggal_spt)->isoFormat('D MMMM Y')}},
            yang bertandatangan di bawah ini:</p>
        <br>
        <div class="section">
            <div class="form-group">
                <p style="text-indent: 18px; text-align: justify"><span class="label">Nama</span>: {{
                    $timPemeriksa->nama }}</p>
                <p style="text-indent: 18px; text-align: justify"><span class="label">NPP</span>: {{ $timPemeriksa->npp
                    }}</p>
            </div>
        </div>
        <br>
        <p style="text-indent: 35px;">Menerangkan catatan hasil pemeriksaan atas nama Badan Usaha {{
            $badanUsaha->nama_badan_usaha
            }}, sebagai
            berikut:</p>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p style="text-indent: 35px; text-align: justify;">Sebagai tindaklanjut atas hasil pemeriksaan yang telah
            dilakukan, BPJS Kesehatan
            akan
            menyampaikan kepada Pimpinan atau Pejabat yang ditunjuk ({{ $badanUsaha->nama_badan_usaha }}) Surat
            Pemberitahuan Hasil
            Pemeriksaan atau BPJS Kesehatan dapat melakukan permintaan data atau keterangan dalam hal masih diperlukan
            data untuk mendukung proses pemeriksaan atas kepatuhan.</p> <br>
        <p style="text-indent: 35px; text-align: justify;">Demikian Formulir Catatan Hasil Pemeriksaan ini dibuat dengan
            sebenarnya dan telah
            disampaikan pada akhir sesi pemeriksaan.</p>
    </div>
    <br>
    <p style="text-align: right; margin-bottom:-8px; margin-right: 5px">Gorontalo, {{
        \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
    <p style="text-align: left; margin-bottom:-8px; margin-left: 67px">{{ $badanUsaha->nama_badan_usaha }},</p>
    <div class="signature-container" style="text-align: right;">
        <div class="signature">
            <div style="float: right; text-align: left; margin-right: 67px;">
                <br><br><br><br>
                <p>{{ $timPemeriksa->nama }}</p>
                <p> NPP : {{ $timPemeriksa->npp }}</p>
            </div>

            <div style="float: left; text-align: left; margin:left 67px">
                <br><br><br><br>
                <p style="border-bottom: 1px solid #000; padding-bottom: 0;">{{ $bapket->nama_pemberi_kerja }}</p>
                <p> Jabatan : {{ $bapket->jabatan }}</p>
            </div>
        </div>
    </div>
    <div class="page-break"></div>
    <div class="content">
        <br>
        <p class="centered"><strong>BERITA ACARA PENGAMBILAN KETERANGAN</strong></p>
        <p class="centered"><strong>Nomor : {{ $bapket->no_bapket }}</strong></p>
    </div>
    <p style="text-indent: 35px; text-align: justify">
        Pada hari ini {{ \Carbon\Carbon::now()->isoFormat('dddd') }} Tanggal {{ \Carbon\Carbon::now()->isoFormat('D')
        }} Bulan {{ \Carbon\Carbon::now()->isoFormat('MMMM') }} Tahun Dua Ribu Dua Puluh Tiga berdasarkan
        Surat Perintah Tugas Nomor: {{ $spt->nomor_spt }} tanggal {{
        \Carbon\Carbon::parse($spt->tanggal_spt)->isoFormat('D MMMM Y') }} yang bertandatangan di bawah ini:
    </p>
    <br>
    <div class="section">
        <div class="form-group">
            <p style="text-indent: 19px;"><span class="label">Nama</span>: {{ $timPemeriksa->nama }}</p>
            <p style="text-indent: 19px;"><span class="label">NPP</span>: {{ $timPemeriksa->npp }}</p>
        </div>
    </div>
    <p style="text-indent: 35px; text-align: justify">
        <span>Dalam hal ini bertindak sebagai Petugas Pemeriksa Badan Penyelenggara Jaminan Sosial Kesehatan (BPJS
            Kesehatan).</span>
    </p>
    <br>
    <div class="section">
        <div class="form-group">
            <p style="text-indent: 19px;"><span class="label">Nama</span>: {{ $bapket->nama_pemberi_kerja }}</p>
            <p style="text-indent: 19px;"><span class="label">Jabatan</span>: {{ $bapket->jabatan }}</p>
            <p style="text-indent: 19px;"><span class="label">Nama Pemberi Kerja</span>: {{
                $badanUsaha->nama_badan_usaha }}</p>
            <p style="text-indent: 19px;"><span class="label">Kode Badan Usaha</span>: {{ $badanUsaha->kode_badan_usaha
                }}</p>
        </div>
    </div>


    <p style='text-indent: 35px; text-align: justify'>
        <span>Dalam hal ini bertindak sebagai Perwakilan
            Pemberi Kerja.</span>
    </p>
    <br>
    <p style="text-indent: 35px; text-align: justify">BPJS Kesehatan dan
        Pemberi Kerja bersama ini menerangkan bahwa telah dilakukan Pengambilan Keterangan atas Kepatuhan Program
        Jaminan Sosial Kesehatan, dengan hasil berikut :</p><br>
    <table style="border-collapse:collapse;border:none; width:100%;">
        <tbody>
            <tr>
                <td style="width:464.4pt;border:solid black 1.0pt;padding:  0cm 5.4pt 0cm 5.4pt;height:22.7pt;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;text-align:center;line-height:normal;'>
                        <strong><span style='font-size:16px;font-family:"Arial",sans-serif;'>Kepatuhan Pembayaran
                                Iuran</span></strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width: 464.4pt;border-right: 1pt solid black;border-bottom: 1pt solid black;border-left: 1pt solid black;border-image: initial;border-top: none;margin: 5px;vertical-align: top;">
                    <p>
                        <span class="label">Tunggakan Iuran</span>: Rp. {{ number_format($badanUsaha->jumlah_tunggakan, 2, ',', '.') }}
                    </p>
                    <p>
                        <span class="label">Bulan Menunggak</span>: {{ $bapket->bulan_menunggak }}
                    </p>
                    <p>
                        <span class="label">Sebab menunggak</span>: {{ $bapket->sebab_menunggak }}
                    </p>
                </td>
            </tr>
        </tbody>
    </table><br>
    <p style="text-indent: 35px; text-align: justify">
        Sebagai tindaklanjut atas hasil pemeriksaan yang telah dilakukan, BPJS Kesehatan akan menyampaikan kepada
        Pimpinan atau Pejabat yang ditunjuk berupa Surat Pemberitahuan Hasil Pemeriksaan selambat-lambatnya 3 (tiga)
        hari kerja sejak ditandatanganinya Berita Acara ini atau BPJS Kesehatan dapat melakukan permintaan data atau
        keterangan dalam hal masih diperlukan data untuk mendukung proses pemeriksaan atas kepatuhan.</p>
    <br>
    <p style="text-align: right; margin-bottom:-8px; margin-right: 5px">Gorontalo, {{
        \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
    <p style="text-align: left; margin-bottom:-8px; margin-left: 67px">{{ $badanUsaha->nama_badan_usaha }},</p>
    <div class="signature-container" style="text-align: right;">
        <div class="signature">
            <div style="float: right; text-align: left; margin-right: 67px;">
                <br><br><br><br>
                <p>{{ $timPemeriksa->nama }}</p>
                <p> NPP : {{ $timPemeriksa->npp }}</p>
            </div>
            <div style="float: left; text-align: left; margin:left 67px">
                <br><br><br><br>
                <p style="border-bottom: 1px solid #000; padding-bottom: 0;">{{ $bapket->nama_pemberi_kerja }}</p>
                <p> Jabatan : {{ $bapket->jabatan }}</p>
            </div>
        </div>
    </div>
</body>

</html>