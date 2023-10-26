<?php

namespace App\Exports;

use App\Models\BadanUsaha;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithView;

class ProgramPemeriksaan implements FromCollection, WithStyles, WithEvents

{
    protected $badanUsaha;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct(BadanUsaha $badanUsaha)
    {
        $this->badanUsaha = $badanUsaha->id;
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
        return [

            'A1:L1' => [
                'font' => [
                    'bold' => true, // Tebal (bold)
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'A3:L9' => [
                'font' => [
                    'bold' => true, // Tebal (bold)
                    'size' => 10,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
            ],
            'A4:E9' => [
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $sheet->setCellValue('A1', 'PERENCANAAN PEMERIKSAAN');
                $sheet->mergeCells('A1:L1');

                $data = BadanUsaha::findOrFail($this->badanUsaha);

                unset($data['created_at']);
                unset($data['updated_at']);
                unset($data['perencanaan_id']);

                $sheet->setCellValue('A3', 'Kertas Kerja Pemeriksaan');
                $sheet->mergeCells('A3:E3');
                $sheet->setCellValue('A4', 'Program Pemeriksaan');
                $sheet->mergeCells('A4:E9');

                $sheet->setCellValue('F3', 'Nama BU');
                $sheet->mergeCells('F3:H3');
                $sheet->setCellValue('F4', 'Alamat BU');
                $sheet->mergeCells('F4:H4');
                $sheet->setCellValue('F5', 'Kode BU');
                $sheet->mergeCells('F5:H5');
                $sheet->setCellValue('F6', 'NPWP');
                $sheet->mergeCells('F6:H6');
                $sheet->setCellValue('F7', 'Bulan Pemeriksaan');
                $sheet->mergeCells('F7:H7');
                $sheet->setCellValue('F8', 'Mekanisme Pemeriksaan');
                $sheet->mergeCells('F8:H8');
                $sheet->setCellValue('F9', 'Jenis Ketidakpatuhan');
                $sheet->mergeCells('F9:H9');

                // Menentukan sel-sel Excel untuk mengisi data
                $sheet->setCellValue('I3', $data->nama_badan_usaha);
                $sheet->mergeCells('I3:L3');
                $sheet->setCellValue('I4', $data->alamat);
                $sheet->mergeCells('I4:L4');
                $sheet->setCellValue('I5', $data->kode_badan_usaha);
                $sheet->mergeCells('I5:L5');
                $sheet->setCellValue('I6', ''); // Gantilah dengan data yang sesuai
                $sheet->mergeCells('I6:L6');
                $sheet->setCellValue('I7', $data->jadwal_pemeriksaan);
                $sheet->mergeCells('I7:L7');
                $sheet->setCellValue('I8', ''); // Gantilah dengan data yang sesuai
                $sheet->mergeCells('I8:L8');
                $sheet->setCellValue('I9', $data->jenis_ketidakpatuhan);
                $sheet->mergeCells('I9:L9');

                $sheet->setCellValue('A11', 'I. Pendahuluan');
                $sheet->mergeCells('A11:L11');
                $sheet->setCellValue('B12', 'A.');
                $sheet->setCellValue('C12', 'Tujuan');
                $sheet->setCellValue('C13', 'Untuk mengetahui pemberi kerja telah melaksanakan ketentuan kewajiban pendaftaran program jaminan sosial sesuai ketentuan Pasal 15 ayat (1) dan (2), Pasal 19 ayat (1) dan (2) UU Nomor 24/2011 Tentang BPJS, meliputi :');
                $sheet->mergeCells('C13:L14');
                $sheet->getStyle('C13:L14')->getAlignment()->setWrapText(true);
            },
        ];
    }
}
