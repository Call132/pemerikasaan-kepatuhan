<?php

namespace App\Exports;

use App\Models\BadanUsaha;
use App\Models\employee_roles;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithView;

class KertasPemeriksaan implements FromCollection, WithStyles, WithEvents

{
    protected $badanUsaha;
    protected $npwp, $refPekerja, $pemeriksa, $master_file, $koreksi, $refIuran, $totalPekerja, $bulanMenunggak;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($badanUsaha, $npwp, $refPekerja, $pemeriksa, $master_file, $koreksi, $refIuran, $totalPekerja, $bulanMenunggak)
    {
        $this->badanUsaha = $badanUsaha->id;
        $this->npwp = $npwp;
        $this->refPekerja = $refPekerja;
        $this->pemeriksa = $pemeriksa;
        $this->master_file = $master_file;
        $this->koreksi = $koreksi;
        $this->refIuran = $refIuran;
        $this->totalPekerja = $totalPekerja;
        $this->bulanMenunggak = $bulanMenunggak;
    }



    /*public function view(): View
    {
        return view('export.exportProgramPemeriksaan', [
            'badanUsaha' => $this->badanUsaha,
        ]);
    }*/
    public function collection()
    {
        $data = BadanUsaha::findOrFail($this->badanUsaha);
        $data = collect([]);


        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(8.6);
        $sheet->getColumnDimension('D')->setWidth(15.1);
        $sheet->getColumnDimension('I')->setWidth(15.1);
        $sheet->getColumnDimension('H')->setWidth(14.1);
        $sheet->getColumnDimension('G')->setWidth(11.8);
        $sheet->getColumnDimension('F')->setWidth(15.6);
        $sheet->getColumnDimension('E')->setWidth(8.6);
        $sheet->getColumnDimension('A')->setWidth(3.8);
        return [


            'A1:I1' => [
                'font' => [
                    'bold' => true, // Tebal (bold)
                    'size' => 14,

                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'A1:I30' => [
                'font' => [
                    'size' => 10,


                ],

            ],
            
            
            'A11' => [
                'font' => [
                    'bold' => true, // Tebal (bold)

                    'size' => 11,
                ],
                'alignment' => [
                    'horizontal' => 'left', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'A12' => [
                'font' => [
                    // Mengatur font Arial
                    'size' => 11,
                ],
                'alignment' => [
                    'horizontal' => 'left', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'D3:I9' => [
                'font' => [
                    // Mengatur font Arial
                    'size' => 10,
                ],
                'alignment' => [
                    'horizontal' => 'left', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
            ],
            'A3:C9' => [
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
                'font' => [
                    // Mengatur font Arial
                    'size' => 11,
                    'bold' => true, // Tebal (bold)
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
            ],
            'D3:F9' => [
                'font' => [
                    // Mengatur font Arial
                    'size' => 10,
                ],
            ],
            'A13:I13' => [
                'font' => [
                    'bold' => true, // Tebal (bold)
                    'size' => 8,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'A14:I15' => [
                'font' => [
                    'size' => 8,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'I14:H15' => [
                'font' => [
                    'size' => 8,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
                
            ],
            'A14:A15' => [
                'font' => [
                    'size' => 8,
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'E14:E15' => [
                'font' => [
                    'size' => 8,
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'B14:D15' => [
                'font' => [
                    'size' => 8,
                ],
                'alignment' => [
                    'horizontal' => 'left', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'I14' => [
                'font' => [
                    'size' => 8,
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'A13:I15' => [
                'font' => [
                    'size' => 8,
                    // Mengatur font Arial
                ],
            ],
            'A17' => [
                'font' => [
                    'bold' => true, // Tebal (bold)
                    // Mengatur font Arial
                    'size' => 11,
                ],
                'alignment' => [
                    'horizontal' => 'left', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'A18:F19' => [
                'font' => [
                    'bold' => true, // Tebal (bold)
                    'size' => 8,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'A20' => [
                'font' => [
                    'size' => 8,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'B20:F20' => [
                'font' => [
                    'size' => 8,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'G18:I20' => [
                'font' => [
                    'size' => 8,
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'A18:I18' => [
                'font' => [
                    'size' => 8,
                    // Mengatur font Arial
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'G18:I20' => [
                'font' => [
                    'size' => 8,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
            ],
            'A22' => [
                'font' => [
                    'bold' => true, // Tebal (bold)
                    // Mengatur font Arial
                    'size' => 11,
                ],
                'alignment' => [
                    'horizontal' => 'left', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'A23:I23' => [
                'font' => [
                    'bold' => true, // Tebal (bold)
                    // Mengatur font Arial
                    'size' => 11,
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
            ],
            'A24:I24' => [
                'font' => [
                    'bold' => true, // Tebal (bold)
                    // Mengatur font Arial
                    'size' => 8,
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
            ],
            'A25:I25' => [
                'font' => [
                    // Mengatur font Arial
                    'size' => 8,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
            ],
            'A25' => [
                'font' => [
                    // Mengatur font Arial
                    'size' => 8,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'B25' => [
                'font' => [
                    'italic' => true, // Tebal (bold)
                    // Mengatur font Arial
                    'size' => 8,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
                'alignment' => [
                    'horizontal' => 'left', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'F25' => [
                'font' => [
                    'italic' => true, // Tebal (bold)
                    // Mengatur font Arial
                    'size' => 8,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
                'alignment' => [
                    'horizontal' => 'left', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'A28:I28' => [
                'font' => [
                    'bold' => true, // Tebal (bold)
                    // Mengatur font Arial
                    'size' => 8,
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
            ],
            'A29:I29' => [
                'font' => [
                    'bold' => true, // Tebal (bold)
                    // Mengatur font Arial
                    'size' => 8,
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
            ],
            'A30:I33' => [
                'font' => [
                    // Mengatur font Arial
                    'size' => 8,
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
            ],
            'A30:B33' => [
                'font' => [
                    // Mengatur font Arial
                    'size' => 8,
                    'bold' => true, // Tebal (bold)
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
            ],
            'F30:G33' => [
                'font' => [
                    // Mengatur font Arial
                    'size' => 8,
                    'bold' => true, // Tebal (bold)
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $sheet->setCellValue('A1', 'KERTAS KERJA PEMERIKSAAN');
                $sheet->mergeCells('A1:I1');

                $data = BadanUsaha::findOrFail($this->badanUsaha);

                unset($data['created_at']);
                unset($data['updated_at']);
                unset($data['perencanaan_id']);
                $jadwal_pemeriksaan = Carbon::parse($data->jadwal_pemeriksaan)->isoFormat('MMMM', 'ID');
                $jumlah_tunggakan = number_format($data->jumlah_tunggakan, 0, ',', '.');

                $employee = employee_roles::where('posisi', 'Kepala Bagian')->pluck('nama')->first();
                $petugasPemeriksa = employee_roles::where('posisi', 'Tim Pemeriksa')->pluck('nama')->first();

                $sheet->setCellValue('A3', 'Kertas Kerja Pemeriksaan');
                $sheet->mergeCells('A3:C9');
                $sheet->getStyle('A3')->getAlignment()->setWrapText(true); // Aktifkan wrap text

                $sheet->setCellValue('D3', 'Nama BU');
                $sheet->mergeCells('D3:F3');
                $sheet->setCellValue('D4', 'Alamat BU');
                $sheet->mergeCells('D4:F4');
                $sheet->setCellValue('D5', 'Kode BU');
                $sheet->mergeCells('D5:F5');
                $sheet->setCellValue('D6', 'NPWP');
                $sheet->mergeCells('D6:F6');
                $sheet->setCellValue('D7', 'Bulan Pemeriksaan');
                $sheet->mergeCells('D7:F7');
                $sheet->setCellValue('D8', 'Mekanisme Pemeriksaan');
                $sheet->mergeCells('D8:F8');
                $sheet->setCellValue('D9', 'Jenis Ketidakpatuhan');
                $sheet->mergeCells('D9:F9');

                // Menentukan sel-sel Excel untuk mengisi data
                $sheet->setCellValue('G3', $data->nama_badan_usaha);
                $sheet->mergeCells('G3:I3');
                $sheet->setCellValue('G4', $data->alamat);
                $sheet->mergeCells('G4:I4');
                $sheet->setCellValue('G5', $data->kode_badan_usaha);
                $sheet->mergeCells('G5:I5');
                $sheet->setCellValue('G6', $this->npwp); // Gantilah dengan data yang sesuai
                $sheet->mergeCells('G6:I6');
                $sheet->setCellValue('G7', $jadwal_pemeriksaan);
                $sheet->mergeCells('G7:I7');
                $sheet->setCellValue('G8', 'pemeriksaan ' . $data->jenis_pemeriksaan); // Gantilah dengan data yang sesuai
                $sheet->mergeCells('G8:I8');
                $sheet->setCellValue('G9', $data->jenis_ketidakpatuhan);
                $sheet->mergeCells('G9:I9');

                $sheet->setCellValue('A11', 'A. Identifikasi Pekerja');
                $sheet->mergeCells('A11:I11');
                $sheet->setCellValue('A12', 'Berdasarkan hasil pemeriksaan diperoleh rumusan temuan atas indentifikasi pekerja :');
                $sheet->mergeCells('A12:I12');
                $sheet->getRowDimension(14)->setRowHeight(27);
                $sheet->getRowDimension(15)->setRowHeight(27);
                $sheet->setCellValue('A13', 'NO');
                $sheet->setCellValue('A14', '1.');
                $sheet->mergeCells('A14:A15');
                $sheet->setCellValue('B13', 'Uraian');
                $sheet->setCellValue('B14', 'Menunggak pembayaran iuran');
                $sheet->mergeCells('B13:D13');
                $sheet->mergeCells('B14:D15');
                $sheet->setCellValue('E13', 'Ref.');
                $sheet->setCellValue('E14', $this->refPekerja);
                $sheet->mergeCells('E14:E15');
                $sheet->setCellValue('F13', 'Pemeriksa');
                $sheet->setCellValue('F14', $this->pemeriksa);
                $sheet->mergeCells('F14:F15');
                $sheet->setCellValue('G13', 'Master File');
                $sheet->setCellValue('G14', $this->master_file);
                $sheet->mergeCells('G14:G15');
                $sheet->setCellValue('H13', 'Koreksi');
                $sheet->setCellValue('H14', $this->koreksi);
                $sheet->mergeCells('H14:H15');
                $sheet->setCellValue('I13', 'Keterangan');
                $sheet->setCellValue('I14', 'Total Tunggakan :');
                $sheet->setCellValue('I15', 'Rp.' . $jumlah_tunggakan);

                $sheet->setCellValue('A17', 'B. Identifikasi Perhitungan Iuran');
                $sheet->mergeCells('A17:I17');
                $sheet->getRowDimension(18)->setRowHeight(27);
                $sheet->getRowDimension(19)->setRowHeight(27);
                $sheet->getRowDimension(20)->setRowHeight(30);
                $sheet->setCellValue('A18', 'NO');
                $sheet->mergeCells('A18:A19');
                $sheet->setCellValue('A20', '1.');
                $sheet->setCellValue('B18', 'NO');
                $sheet->mergeCells('B18:B19');
                $sheet->setCellValue('B20', 'Menunggak pembayaran iuran');
                $sheet->getStyle('B20')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->setCellValue('C18', 'Ref');
                $sheet->setCellValue('C20', $this->refIuran);
                $sheet->mergeCells('C18:C19');
                $sheet->setCellValue('D18', 'Total Pekerja');
                $sheet->setCellValue('D20', $this->totalPekerja);
                $sheet->mergeCells('D18:D19');
                $sheet->setCellValue('E18', 'Jumlah Bulan Menunggak');
                $sheet->setCellValue('E20', $this->bulanMenunggak);
                $sheet->mergeCells('E18:E19');
                $sheet->getStyle('E18')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->setCellValue('F18', 'Total Tunggakan');
                $sheet->setCellValue('F20', 'Rp.' . $jumlah_tunggakan);
                $sheet->mergeCells('F18:F19');
                $sheet->setCellValue('G18', 'Pimpinan mengakui dan bersedia untuk melakukan pembayaran iuran');
                $sheet->mergeCells('G18:I20');
                $sheet->getStyle('G18')->getAlignment()->setWrapText(true); // Aktifkan wrap text

                $sheet->setCellValue('A22', 'C. Penjelasan Uraian');
                $sheet->mergeCells('A22:I22');
                $sheet->setCellValue('A23', 'Penjelasan');
                $sheet->mergeCells('A23:I23');
                $sheet->setCellValue('A24', 'No.');
                $sheet->setCellValue('B24', 'Uraian');
                $sheet->mergeCells('B24:E24');
                $sheet->setCellValue('F24', 'Dasar Hukum');
                $sheet->mergeCells('F24:I24');
                $sheet->setCellValue('A25', '1');
                $sheet->getRowDimension(25)->setRowHeight(27);
                $sheet->setCellValue('B25', 'Menunggak pembayaran iuran');
                $sheet->getStyle('B25')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->mergeCells('B25:E25');
                $sheet->setCellValue('F25', 'Pasal 19 ayat (1) dan (2) Undang-undang Nomor 24 Tahun 2011 Tentang BPJS');
                $sheet->getStyle('F25')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->mergeCells('F25:I25');

                $sheet->setCellValue('A28', 'Disusun Oleh');
                $sheet->getStyle('A28')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->mergeCells('A28:E28');
                $sheet->setCellValue('F28', 'Ditelaah Oleh');
                $sheet->getStyle('F28')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->mergeCells('F28:I28');
                $sheet->setCellValue('A29', 'Nama/Jabatan');
                $sheet->getStyle('A29')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->mergeCells('A29:B29');
                $sheet->setCellValue('C29', 'Tanggal');
                $sheet->getStyle('C29')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->setCellValue('D29', 'Tanda Tangan');
                $sheet->getStyle('D29')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->mergeCells('D29:E29');
                $sheet->setCellValue('F29', 'Nama/Jabatan');
                $sheet->getStyle('F29')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->mergeCells('F29:G29');
                $sheet->setCellValue('H29', 'Tanggal');
                $sheet->getStyle('H29')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->setCellValue('I29', 'Tanda Tangan');
                $sheet->getStyle('I29')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->setCellValue('A30', $petugasPemeriksa . ' (Petugas Pemeriksa)');
                $sheet->getStyle('A30')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->mergeCells('A30:B33');
                $sheet->setCellValue('C30', '');
                $sheet->getStyle('A30')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->mergeCells('C30:C33');
                $sheet->mergeCells('D30:E33');
                $sheet->setCellValue('F30', $employee . ' (KABAG. PKP)');
                $sheet->getStyle('F30')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->mergeCells('F30:G33');
                $sheet->setCellValue('H30', '');
                $sheet->getStyle('H30')->getAlignment()->setWrapText(true); // Aktifkan wrap text
                $sheet->mergeCells('H30:H33');
                $sheet->mergeCells('I30:I33');
            },
        ];
    }
}
