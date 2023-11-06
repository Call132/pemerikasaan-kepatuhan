<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pemberitahuan Hasil Pemeriksaan</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            text-align: justify;
            word-spacing: 1px;
            margin: 40px;

        }

        p {
            margin: 0px;
            margin-left: 18px;

        }

        .content {
            margin-top: 10px;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            text-align: left;
            font-size: 10px;
        }

        .label {
            display: inline-block;
            min-width: 100px;
            /* Sesuaikan dengan lebar minimum yang Anda inginkan */
        }

        .page1 {
            page-break-before: auto;
            /* Jangan menggunakan page break di halaman pertama */
        }

        /* CSS untuk halaman kedua */
        .page2 {
            page-break-before: always;
            /* Beri page break sebelum halaman kedua */
        }

        .div {
            margin-bottom: 10px;
        }

        .position {
            position: absolute;
            top: 20px;
            right: 65px;

        }
    </style>
</head>

<body>


    <div class="header">
        <p class="label">Nomor </p>: {{ $sphp->no_sphp }} <br>
        <p class="label">Hal </p>: Pemberitahuan Hasil Pemeriksaan
    </div>
    <div class="position">
        Gorontalo, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}
    </div>
    <div class="content  page1">
        <div class="div">
            <p style="padding-bottom: 2px;">Yth. Pimpinan ({{ $badanUsaha->nama_badan_usaha }}) <br>
                ({{ $badanUsaha->alamat }}) <br>
                di <br>
                Tempat</p> <br>
        </div>


        <div class="div">
            <p style="text-indent: 35px;">Sehubungan dengan telah dilaksanakan pemeriksaan {{
                $badanUsaha->jenis_pemeriksaan }} terhadap Badan Usaha
                ({{ $badanUsaha->nama_badan_usaha }}) pada
                tanggal ({{ \Carbon\Carbon::parse($sphp->tgl_sphp)->isoFormat('D MMMM Y') }}) berdasarkan Surat Perintah
                Tugas Nomor : ({{ $spt->nomor_spt }}) tanggal ({{\Carbon\Carbon::parse($spt->tanggal_spt)->isoFormat('D
                MMMM Y')}}),
                maka bersama ini kami sampaikan hal-hal sebagai berikut:</p>
        </div>


        <div class="div">
            <p>1. Bahwa hasil pemeriksaan lapangan terhadap ({{ $badanUsaha->nama_badan_usaha }}), sebagai berikut:
            </p>

            <p style="margin-left: 35px;">a. {{ $sphp->p_a }}</p>
            <p style="margin-left: 35px;">b. {{ $sphp->p_b }}</p>
            <p style="margin-left: 35px;">c. {{ $sphp->p_c }}</p>
        </div>
        <div class="div">
            <p style="text-align: justify">2. Mengacu pada pasal 19 Undang-undang Nomor 24 Tahun 2011 Tentang BPJS, yang
                menyebutkan:
            <p style="margin-left: 35px;">
                a. Pemberi Kerja wajib melaporkan pelanggaran ketentuan yang berlaku di Badan Usaha. Pemberi Kerja wajib
                memungut iuran yang menjadi beban Peserta dan
                Pekerjanya dan Menyetorkannya kepada
                BPJS.</p>
            <p style="margin-left: 35px;">b. Pemberi Kerja wajib membayar dan menyetor iuran yang menjadi
                tanggungjawabnya kepada BPJS.</p>
            </p>
        </div>
        <div class="div">
            <p>Bahwa sanksi atas pelanggaran Pasal 19 Undang-undang Nomor 24 Tahun 2011 Tentang BPJS tersebut diatur
                dalam
                Pasal 55 undang-undang tersebut, yaitu:</p>
            <strong
                style="font-style: italic; margin: 0 80px; display: inline-block; text-align: justify; max-width: 100%;">"Pemberi
                Kerja
                yang melanggar ketentuan sebagaimana dimaksud dalam Pasal 19 ayat (1) atau ayat (2)
                dipidana
                dengan pidana penjara paling lama 8 (delapan) tahun atau pidana denda paling banyak Rp. 1.000.000.000,00
                (satu miliar rupiah)"</strong>
        </div>
        <div class="div">
            <p>3. Sesuai Peraturan Presiden Nomor 82 Tahun 2018 Tentang Jaminan Kesehatan Pasal 22 ayat (2) menyatakan
                Pemberi Kerja wajib melaporkan perubahan data kepesertaan sebagaimana dimaksud pada ayat (1) kepada BPJS
                Kesehatan paling lambat 7 (tujuh) hari sejak terjadinya perubahan data oleh Pekerja.</p>
        </div>
        <div class="div">
            <p>4. Sesuai Peraturan Presiden Nomor 82 Tahun 2018 Tentang Jaminan Kesehatan menyatakan Pemberi Kerja wajib
                memungut iuran dari Pekerjanya, membayar iuran yang menjadi tanggungjawabnya, dan menyetor iuran
                tersebut
                kepada BPJS Kesehatan paling lambat tanggal 10 setiap Bulan.</p>
        </div>
    </div>
    <div class="content page2">
        <div style="display: flex;">

            <p style="margin-left: 35px;">a. Apabila Pemberi Kerja tidak membayar iuran sampai dengan akhir bulan
                berjalan maka penjaminan Peserta
                diberhentikan sementara sejak tanggal 1 bulan berikutnya dan Pemberi Kerja wajib bertanggungjawab
                pada saat
                pekerjanya membutuhkan pelayanan kesehatan sesuai dengan Manfaat yang diberikan BPJS Kesehatan.
                Penghentian
                sementara penjaminan peserta berakhir dan status kepesertaan aktif kembali, apabila:
            </p>

        </div>
        <br>
        <div style="display: flex;">
            <p style="margin-left: 45px;">1) telah membayar iuran bulan tertunggak, paling banyak untuk waktu 24
                (dua
                puluh empat) bulan dan</p>
        </div>




        <div style="display: flex;">
            <p style="margin-left: 45px;">2) membayar iuran pada bulan saat Peserta ingin mengakhiri pemberhentian
                sementara jaminan.</p>
        </div>

        <br>
        <div class="div">
            <div style="display: flex;">
                <p style="margin-left: 35px;">b. Bahwa dalam waktu 45 (empat puluh lima) hari sejak status kepesertaan
                    aktif kembali, Pemberi Kerja
                    wajib
                    membayar denda sebesar 5% (lima persen) dari perkiraan biaya paket Indonesian Case Based Groups
                    berdasarkan
                    diagnosa dan prosedur awal untuk setiap bulan tertuggak kepada BPJS Kesehatan untuk setiap pelayanan
                    kesehatan rawat inap tingkat lanjutan yang diperoleh Peserta (Pekerja Badan Usaha).</p>
                </p>
            </div>
        </div>

        <div class="div">
            <strong>
                <p>5. Sehubungan dengan hal-hal di atas, maka dimohon kepada Bpk./Ibu Pimpinan/Direktur Badan Usaha
                    WAJIB
                    dan
                    SEGERA melakukan pembayaran tunggakkan iuran paling lambat 3 (tiga) hari kerja sejak tanggal
                    dikeluarkannya
                    surat pemberitahuan hasil pemeriksaan ini.</p>
            </strong>
        </div>
        <div class="div">
            <p>6. Bapak/Ibu Pimpinan/Direktur dapat menyampaikan tanggapan beserta bukti pendukung atas tanggapan
                dimaksud
                paling lambat 3 hari kerja sejak surat ini diterima. Jika dalam jangka waktu yang telah ditentukan
                tersebut
                tidak menyampaikan tanggapan secara tertulis, maka Laporan Hasil Pemeriksaan Sementara akan ditetapkan
                sebagai Laporan Hasil Pemeriksaan Akhir.</p>
        </div>
        <div class="div">
            <p>7. Bahwa Jaminan Kesehatan Nasional yang diselenggarakan oleh BPJS Kesehatan menganut Prinsip
                Gotong-Royong
                yang mengandung makna dan tujuan agar Peserta yang Sehat membantu biaya pelayanan Peserta yang sakit
                atau
                yang Mampu dalam financial membantu biaya pelayanan yang kurang mampu dalam hal financial, sehingga
                wajib
                bagi setiap warga Negara Republik Indonesia dan Orang Asing untuk patuh melaksanakan kewajiban dalam
                penyelenggaraan program JKN-KIS.</p>
        </div>

    </div>
    <div style="text-align: right;">
        <div class="signature">
            <p style="margin-right: 65px;">Kepala Cabang</p>
            <br><br><br>
            <p style="margin-right: 55px;">{{ $employee }}</p>
        </div>
        <div class="footer">
            <p>RL/ta/PP.01.02</p>
        </div>
    </div>
</body>

</html>