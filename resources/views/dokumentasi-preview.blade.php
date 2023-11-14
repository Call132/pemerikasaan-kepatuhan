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

        .label {

            display: inline-block;
            min-width: 180px;
            /* Sesuaikan dengan lebar minimum yang Anda inginkan */
        }
    </style>
</head>

<body>
    <div class="header">
        <p class="label" >Nama Badan Usaha </p>: {{ $badanUsaha->nama_badan_usaha}} <br>
        <p class="label" >Hari/Tanggal </p>: {{
        \Carbon\Carbon::parse($lhps->tgl_lhps)->isoFormat('dddd, D MMMM Y') }}
        <br>
        <p class="label">Tim Pemeriksa </p>: {{ $timPemeriksa->nama }} <br>
        @foreach ($pendamping as $item)
        <p class="label" style="min-width: 182px;"> </p> {{ $item->nama }} <br>
        @endforeach
        <p class="label" style="min-width: 182px; margin-bottom: 10px;"> </p> {{ $extPendamping->nama }}
    </div>
    <div class="content" style="max-height: 350px; max-width: 600px;  overflow:hidden;">
        <img src="{{ asset('storage/' . substr($lhps->image, 7)) }}" alt="{{ 'Dokumentasi ' .  $lhps->image }}"
            class="img-fluid mt-3" width="500" height="300">
    </div>
</body>

</html>