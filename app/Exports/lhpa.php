<?php

namespace App\Exports;

use App\Models\BadanUsaha;
use App\Models\employee_roles;
use App\Models\extPendamping;
use App\Models\Pendamping;
use App\Models\TimPemeriksa;
use Carbon\Carbon;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use NumberFormatter;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class lhpa implements FromCollection, WithStyles, WithEvents
{
    protected $badanUsaha, $jumlahTunggakan,
        $bulanMenunggak,
        $jumlahPekerja,
        $tindakLanjut,
        $spt,
        $rekomendasiPemeriksa;

    public function __construct(
        $badanUsaha,
        $jumlahTunggakan,
        $bulanMenunggak,
        $jumlahPekerja,
        $tindakLanjut,
        $spt,
        $rekomendasiPemeriksa
    ) {
        $this->badanUsaha = $badanUsaha->id;
        $this->jumlahTunggakan = $jumlahTunggakan;
        $this->bulanMenunggak = $bulanMenunggak;
        $this->jumlahPekerja = $jumlahPekerja;
        $this->tindakLanjut = $tindakLanjut;
        $this->spt = $spt;
        $this->rekomendasiPemeriksa = $rekomendasiPemeriksa;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = BadanUsaha::findOrFail($this->badanUsaha);
        $data = collect([]);

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G27')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:G27')->getFont()->setName('Arial');
        $sheet->getStyle('A17:G27')->getFont()->setSize(10);
        $sheet->getColumnDimension('A')->setWidth(17);
        $sheet->getColumnDimension('B')->setWidth(2);
        $sheet->getColumnDimension('C')->setWidth(14);
        $sheet->getColumnDimension('D')->setWidth(14);
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getColumnDimension('F')->setWidth(16);
        $sheet->getColumnDimension('G')->setWidth(22);

        $sheet->getRowDimension('1')->setRowHeight(11);
        $sheet->getRowDimension('2')->setRowHeight(22);
        $sheet->getRowDimension('3')->setRowHeight(26);
        $sheet->getRowDimension('4')->setRowHeight(31);
        $sheet->getRowDimension('5')->setRowHeight(31);
        $sheet->getRowDimension('6')->setRowHeight(31);
        $sheet->getRowDimension('7')->setRowHeight(16);
        $sheet->getRowDimension('8')->setRowHeight(16);
        $sheet->getRowDimension('9')->setRowHeight(16);
        $sheet->getRowDimension('10')->setRowHeight(16);
        $sheet->getRowDimension('11')->setRowHeight(16);
        $sheet->getRowDimension('12')->setRowHeight(46);
        $sheet->getRowDimension('13')->setRowHeight(56);
        $sheet->getRowDimension('14')->setRowHeight(51);
        $sheet->getRowDimension('15')->setRowHeight(51);
        $sheet->getRowDimension('16')->setRowHeight(11);
        $sheet->getRowDimension('17')->setRowHeight(14);
        $sheet->getRowDimension('18')->setRowHeight(26);
        $sheet->getRowDimension('19')->setRowHeight(26);
        $sheet->getRowDimension('20')->setRowHeight(26);
        $sheet->getRowDimension('21')->setRowHeight(14);
        $sheet->getRowDimension('22')->setRowHeight(22);
        $sheet->getRowDimension('23')->setRowHeight(11);
        $sheet->getRowDimension('24')->setRowHeight(16);
        $sheet->getRowDimension('25')->setRowHeight(34);
        $sheet->getRowDimension('26')->setRowHeight(34);
        $sheet->getRowDimension('27')->setRowHeight(34);

        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:D2')->getStyle('A2:D2')->getFont()->setBold(true);
        $sheet->getStyle('A2:D2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('A6A6A6');
        $sheet->mergeCells('E2:G2')->getStyle('E2:G2')->getFont()->setBold(true);
        $sheet->getStyle('E2:G2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('A6A6A6');
        $sheet->mergeCells('F3:G3');
        $sheet->mergeCells('C3:D3');
        $sheet->mergeCells('C4:D4');
        $sheet->mergeCells('C5:D5');
        $sheet->mergeCells('C6:D6');
        $sheet->mergeCells('E4:E6');
        $sheet->mergeCells('F4:G6');

        $sheet->mergeCells('A7:G7')->getStyle('A7:G7')->getFont()->setBold(true);
        $sheet->getStyle('A7:G7')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('A6A6A6');
        $sheet->mergeCells('A8:G8')->getStyle('A8:G8')->getFont()->setBold(true);
        $sheet->mergeCells('A9:C9')->getStyle('A9:C9')->getFont()->setBold(true);
        $sheet->mergeCells('D9:F9')->getStyle('D9:F9')->getFont()->setBold(true);
        $sheet->getStyle('G9')->getFont()->setBold(true);
        $sheet->getStyle('A8:G9')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('BFBFBF');
        $sheet->mergeCells('A10:C10');
        $sheet->mergeCells('D10:F10');

        $sheet->mergeCells('D12:E12');
        $sheet->mergeCells('D13:E13');
        $sheet->mergeCells('D14:E14');
        $sheet->mergeCells('D15:E15');

        $sheet->mergeCells('A11:G11')->getStyle('A11:G11')->getFont()->setBold(true);
        $sheet->getStyle('A11:G11')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('BFBFBF');

        $sheet->mergeCells('A16:G16');
        $sheet->getStyle('A16:G16')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('808080');

        $sheet->mergeCells('A17:G17')->getStyle('A17:G17')->getFont()->setBold(true);
        $sheet->getStyle('A17:G19')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('BFBFBF');

        //$sheet->getStyle('A18:G19')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor('BFBFBF');
        $sheet->mergeCells('A18:B19')->getStyle('A18:B19')->getFont()->setBold(true);
        $sheet->mergeCells('C18:F18')->getStyle('C18:F18')->getFont()->setBold(true);
        $sheet->mergeCells('C19:D19')->getStyle('C19:D19')->getFont()->setBold(true);
        $sheet->mergeCells('G18:G19')->getStyle('G18:G19')->getFont()->setBold(true);
        $sheet->mergeCells('E19:F19')->getStyle('E19:F19')->getFont()->setBold(true);

        $sheet->mergeCells('A20:B20');
        $sheet->mergeCells('C20:D20');
        $sheet->mergeCells('E20:F20');

        $sheet->mergeCells('A21:G21')->getStyle('A21:G21')->getFont()->setBold(true);
        $sheet->getStyle('A21:G21')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('D9D9D9');

        $sheet->mergeCells('A22:G22');

        $sheet->mergeCells('A23:G23');
        $sheet->getStyle('A23:G23')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('808080');

        $sheet->getStyle('E24:G24')->getFont()->setBold(true);

        return [
            'A1:G27' => [
                'font' => [
                    'family' => 'Arial',
                    'size' => 8,
                ],
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin',
                        'color' => ['argb' => '000000'],
                    ]
                ]
            ],
            'A18:G19' => [
                'setfillcolor' => ['argb' => 'BFBFBF']
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $data = BadanUsaha::findOrFail($this->badanUsaha);
                $timPemeriksa = TimPemeriksa::latest()->first();
                $pendamping = Pendamping::where('surat_perintah_tugas_id', $this->spt)->get();
                $extpendamping = extPendamping::where('surat_perintah_tugas_id', $this->spt)->get();

                $formater = new NumberFormatter('id_ID', NumberFormatter::SPELLOUT);

                // Inisialisasi array untuk menyimpan nama pendamping
                $namaPendamping = [];

                // Mengambil nama dari objek Pendamping
                foreach ($pendamping as $pendampingItem) {
                    $namaPendamping[] = $pendampingItem->nama;
                }

                // Mengambil nama dari objek extPendamping
                $namaExtPendamping = [];
                foreach ($extpendamping as $extPendampingItem) {
                    $namaExtPendamping[] = $extPendampingItem->nama;
                }

                $Pemeriksa = array_merge($namaPendamping, $namaExtPendamping); // Menggabungkan kedua array

                $jumlahTunggakan = floatval($this->jumlahTunggakan);
                $formaterr = $formater->format($jumlahTunggakan);
                $format = ucwords($formaterr);




                $timPemeriksaString = implode(', ', $Pemeriksa); // Menggabungkan array dengan pemisah ' dan '


                $jadwalPemeriksaan = Carbon::parse($data->jadwal_pemeriksaan);


                $sheet->setCellValue('A2', 'LAPORAN HASIL PEMERIKSAAN AKHIR (KEPATUHAN PEMBAYARAN IURAN)');
                $sheet->setCellValue('E2', 'SUSUNAN TIM PEMERIKSA');
                $sheet->setCellValue('A3', 'NAMA BU');
                $sheet->setCellValue('A4', 'ALAMAT');
                $sheet->setCellValue('A5', 'KODE BU');
                $sheet->setCellValue('A6', 'TANGGAL PEMERIKSAAN');
                $sheet->setCellValue('B3', ':');
                $sheet->setCellValue('B4', ':');
                $sheet->setCellValue('B5', ':');
                $sheet->setCellValue('B6', ':');
                $sheet->setCellValue('C3', $data->nama_badan_usaha);
                $sheet->setCellValue('C4', $data->alamat);
                $sheet->setCellValue('C5', $data->kode_badan_usaha);
                $sheet->setCellValue('C6', $jadwalPemeriksaan->isoFormat('d MMMM Y', 'ID'));


                $sheet->setCellValue('E3', 'KETUA TIM PEMERIKSA');
                $sheet->setCellValue('E4', $timPemeriksa->nama);
                $sheet->setCellValue('F3', 'TIM PEMERIKSA');
                $sheet->setCellValue('F4', $timPemeriksaString);

                $sheet->setCellValue('A7', 'TEMUAN HASIL PEMERIKSAAN');
                $sheet->setCellValue('A8', 'IDENTIFIKASI TUNGGAKAN IURAN');
                $sheet->setCellValue('A9', 'Jumlah Nominal Tungakan');
                $sheet->setCellValue('A10', 'Rp.' . $this->jumlahTunggakan);
                $sheet->setCellValue('D9', 'Jumlah Bulan Menunggak');
                $sheet->setCellValue('D10', $this->bulanMenunggak);
                $sheet->setCellValue('G9', 'Jumlah Pekerja Terdaftar');
                $sheet->setCellValue('G10', $this->jumlahPekerja);

                $sheet->setCellValue('A11', 'IDENTIFIKASI RINCIAN TUNGGAKAN');
                $sheet->setCellValue('A12', 'Keterangan');
                $sheet->setCellValue('C12', 'TMT Desember 2022');
                $sheet->setCellValue('D12', 'Tahun 2023  (sd. Bulan Pemeriksaan dilakukan)');
                $sheet->setCellValue('F12', 'Total');
                $sheet->setCellValue('G12', 'Pembilang');

                $sheet->setCellValue('A13', 'Bulan Menunggak');
                $sheet->setCellValue('G13', $formater->format($this->jumlahPekerja));
                $sheet->setCellValue('A14', 'Nominal Tunggakan');
                $sheet->setCellValue('G14', $format . ' Rupiah');

                $sheet->setcellvalue('A15', 'Nominal Pembayaran');

                $sheet->setCellvalue('A17', 'TINDAK LANJUT HASIL PEMERIKSAAN :');
                $sheet->setCellvalue('A18', 'Dibayar Seluruhnya');
                $sheet->setCellvalue('C18', 'Dibayar Sebagian');
                $sheet->setCellvalue('C19', 'Relaksasi');
                $sheet->setCellvalue('E19', 'Rekonsiliasi');
                $sheet->setCellvalue('G18', 'Tidak Dibayarkan');

                $sheet->setcellvalue('A21', 'REKOMENDASI PEMERIKSA :');
                $sheet->setcellvalue('A22', $this->rekomendasiPemeriksa);

                $sheet->setCellValue('E24', 'Nama');
                $sheet->setCellValue('F24', 'Tanda Tangan');
                $sheet->setCellValue('G24', 'Tanggal');

                $employeeRoles = employee_roles::whereIn('posisi', ['Tim Pemeriksa', 'Kepala Bagian', 'Kepala Cabang'])->get();

                $sheet->setCellValue('D25', 'Disusun Oleh : Petugas Pemeriksa');
                $sheet->setCellValue('E25', $employeeRoles[0]->nama);
                $sheet->setCellValue('D26', 'Direview Oleh : Kepala Bagian');
                $sheet->setCellValue('E26', $employeeRoles[1]->nama);
                $sheet->setCellValue('D27', 'Disetujui Oleh : Kepala Cabang');
                $sheet->setCellValue('E27', $employeeRoles[2]->nama);
            }
        ];
    }
}
