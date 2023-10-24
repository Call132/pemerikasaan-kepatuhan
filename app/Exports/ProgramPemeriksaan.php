<?php

namespace App\Exports;

use App\Models\BadanUsaha;
use Carbon\Carbon;
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

    public function collection()
    {
        $data = BadanUsaha::findOrFail($this->badanUsaha);
        $data = collect([]);


        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [

            'A1:L62' => [
                'font' => [
                    'size' => 10,
                    'bold' => true, // Tebal (bold) 
                ],

            ],
            'A1:L1' => [
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'A3:L9' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ], // Warna hitam
                ],
            ],
            'C34' => [
                'font' => [
                    'bold' => false, // Tebal (bold)
                ]
            ],
            'C36' => [
                'font' => [
                    'bold' => false, // Tebal (bold)
                ]
            ],
            'A4:E9' => [
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'A39:L40' => [
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'A39:A44' => [
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'A47:L47' => [
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'A47:A58' => [
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
            ],
            'B49:H58' => [
                'font' => [
                    'bold' => false,
                ]
            ],
            'A39:L44' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ]
                ]
            ],
            'A47:L58' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ]
                ]
            ],
            'A60:L65' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'],
                    ]
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
                'font' => [
                    'family' => 'Arial',
                ]
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

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(3);
                $sheet->getColumnDimension('C')->setWidth(3);
                $sheet->getColumnDimension('I')->setWidth(7);
                $sheet->getColumnDimension('J')->setWidth(7);
                $sheet->getColumnDimension('K')->setWidth(7);
                $sheet->getColumnDimension('H')->setWidth(22);
                $sheet->getColumnDimension('L')->setWidth(22);
                $sheet->getRowDimension(61)->setRowHeight(45);
                $data = BadanUsaha::findOrFail($this->badanUsaha);

                unset($data['created_at']);
                unset($data['updated_at']);
                unset($data['perencanaan_id']);
                $jadwal_pemeriksaan = Carbon::parse($data->jadwal_pemeriksaan)->isoFormat('MMMM', 'ID');
                $jumlah_tunggakan = number_format($data->jumlah_tunggakan, 0, ',', '.');

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
                $sheet->setCellValue('I6', '');
                $sheet->mergeCells('I6:L6');
                $sheet->setCellValue('I7', $jadwal_pemeriksaan);
                $sheet->mergeCells('I7:L7');
                $sheet->setCellValue('I8', "Pemeriksaan " . $data->jenis_pemeriksaan);
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

                $sheet->setCellValue('C15', '1)');
                $sheet->setCellValue('D15', 'Pendaftaran Pekerja yang diperkerjakan;');
                $sheet->setCellValue('C16', '2)');
                $sheet->setCellValue('D16', 'Pelaporan Data Gaji/Upah untuk perhitungan Iuran');
                $sheet->setCellValue('D17', 'dan/atau');
                $sheet->setCellValue('C18', '3)');
                $sheet->setCellValue('D18', 'Pembayaran iuran JKN');

                $sheet->setCellValue('B19', 'B.');
                $sheet->setCellValue('C19', 'Teknik Pemeriksaan');
                $sheet->setCellValue('C20', '1)');
                $sheet->setCellValue('D20', 'Pemanfaatan data primer dari internal BPJS Kesehatan');
                $sheet->setCellValue('C21', '2)');
                $sheet->setCellValue('D21', 'Pemanfaatan data sekunder dari internal perusahaan (sebagai objek pemeriksaan)');
                $sheet->setCellValue('C22', '3)');
                $sheet->setCellValue('D22', 'Permintaan Bukti Pendukung');
                $sheet->setCellValue('C23', '4)');
                $sheet->setCellValue('D23', 'Pengujian data');
                $sheet->setCellValue('C24', '5)');
                $sheet->setCellValue('D24', 'Wawancara Mendalam');

                $sheet->setCellValue('B25', 'C.');
                $sheet->setCellValue('C25', 'Prosedur Mendalam');
                $sheet->setCellValue('C26', '1)');
                $sheet->setCellValue('D26', 'Lakukan pengumpulan data dan informasi yang sesuai dengan tujuan');
                $sheet->setCellValue('C27', '2)');
                $sheet->setCellValue('D27', 'Pengolahan data, informasi, dan dokumen');
                $sheet->setCellValue('C28', '3)');
                $sheet->setCellValue('D28', 'Menentukan narasumber');
                $sheet->setCellValue('C29', '4)');
                $sheet->setCellValue('D29', 'Persiapan pelaksanaan pengujian dokumen dan wawancara');
                $sheet->setCellValue('C30', '5)');
                $sheet->setCellValue('D30', 'Lakukan pengujian dokumen wawancara');

                $sheet->setCellValue('A32', 'II. Aspek Pemeriksaan');
                $sheet->setCellValue('B33', 'A.');
                $sheet->setCellValue('C33', 'Aspek Tenaga Kerja');
                $sheet->setCellValue('C34', 'Telah mendaftarkan tenaga kerjanya sesuai dengan data BPJS Ketenagakerjaan');
                $sheet->setCellValue('C35', 'B.');
                $sheet->setCellValue('D35', 'Aspek Iuran');
                $sheet->setCellValue('C36', 'Total Tunggakan : Rp. ' . $jumlah_tunggakan);

                $sheet->setCellValue('A38', 'III. Uraian');
                $sheet->setCellValue('A39', 'No.');
                $sheet->mergeCells('A39:A40');
                $sheet->setCellValue('B39', 'Rincian');
                $sheet->mergeCells('B39:H40');
                $sheet->setCellValue('I39', 'Realisasi');
                $sheet->mergeCells('I39:J39');
                $sheet->setCellValue('K39', 'Keterangan');
                $sheet->setCellValue('I40', 'Ya');
                $sheet->setCellValue('J40', 'Tidak');
                $sheet->mergeCells('K39:L40');

                $sheet->setCellValue('A41', '1');
                $sheet->mergeCells('A41:A42');
                $sheet->setCellValue('B41', 'Aspek Tenaga Kerja');
                $sheet->mergeCells('B41:H41');
                $sheet->setCellValue('B42', 'Telah mendaftarkan tenaga kerjanya sesuai dengan data BPJS Ketenagakerjaan');
                $sheet->mergeCells('B42:H42');
                $sheet->mergeCells('I41:I42');
                $sheet->mergeCells('J41:J42');
                $sheet->mergeCells('K41:L42');

                $sheet->setCellValue('A43', '2');
                $sheet->mergeCells('A43:A44');
                $sheet->setCellValue('B43', 'Aspek Iuran');
                $sheet->mergeCells('B43:H43');
                $sheet->setCellValue('B44', 'Total Tunggakan :');
                $sheet->mergeCells('B44:D44');
                $sheet->setCellValue('E44', 'Rp. ' . $jumlah_tunggakan);
                $sheet->mergeCells('E44:H44');
                $sheet->mergeCells('I43:I44');
                $sheet->mergeCells('J43:J44');
                $sheet->mergeCells('K43:L44');

                $sheet->setCellValue('A46', 'IV. Dokumen/Data yang dipinjam/Diperlihatkan');
                $sheet->setCellValue('A47', 'No');
                $sheet->setCellValue('B47', 'Dokumen/Data');
                $sheet->mergeCells('B47:H47');
                $sheet->setCellValue('I47', 'Keterangan');
                $sheet->mergeCells('I47:L47');
                $sheet->setCellValue('A48', '1');
                $sheet->mergeCells('A48:A53');
                $sheet->setCellValue('B48', 'Peraturan perusahaan terkait ketenagakerjaan');
                $sheet->mergeCells('B48:H48');

                $sheet->setCellValue('B49', 'a. Skala gaji');
                $sheet->mergeCells('B49:H49');
                $sheet->setCellValue('B50', 'b. Jenjang jabatan');
                $sheet->mergeCells('B50:H50');
                $sheet->setCellValue('B51', 'c. Sistem pengupahan');
                $sheet->mergeCells('B51:H51');
                $sheet->setCellValue('B52', 'd. Tunjangan tetap');
                $sheet->mergeCells('B52:H52');
                $sheet->setCellValue('B53', 'e. Jaminan kesehatan pegawai');
                $sheet->mergeCells('B53:H53');
                $sheet->setCellValue('A54', '2');
                $sheet->setCellValue('B54', 'Daftar seluruh pekerja berdasarkan jenjang jabatan disertai dengan NIK Pekerja');
                $sheet->mergeCells('B54:H54');
                $sheet->setCellValue('A55', '3');
                $sheet->setCellValue('B55', 'Struktur Organisasi');
                $sheet->mergeCells('B55:H55');
                $sheet->setCellValue('A56', '4');
                $sheet->setCellValue('B56', 'Daftar Gaji seluruh Pekerja');
                $sheet->mergeCells('B56:H56');
                $sheet->setCellValue('A57', '5');
                $sheet->setCellValue('B57', 'Slip Gaji Pekerja');
                $sheet->mergeCells('B57:H57');
                $sheet->setCellValue('A58', '6');
                $sheet->setCellValue('B58', 'Absensi pekerja');
                $sheet->mergeCells('B58:H58');

                $sheet->mergeCells('I48:L53');


                $sheet->mergeCells('I54:L54');
                $sheet->mergeCells('I55:L55');
                $sheet->mergeCells('I56:L56');
                $sheet->mergeCells('I57:L57');
                $sheet->mergeCells('I58:L58');

                $sheet->setCellValue('A60', 'Disusun Oleh');
                $sheet->mergeCells('A60:G60');
                $sheet->setCellValue('H60', 'Ditelaah Oleh');
                $sheet->mergeCells('H60:L60');

                $sheet->setCellValue('A61', 'Petugas Pemeriksa');
                $sheet->mergeCells('A61:D61');
                $sheet->setCellValue('E61', 'Tanggal');
                $sheet->setCellValue('F61', 'Tanda Tangan');
                $sheet->mergeCells('F61:G61');

                $sheet->setCellValue('H61', 'Kepala Bidang');
                $sheet->mergeCells('H61:I61');
                $sheet->setCellValue('J61', 'Tanggal');
                $sheet->mergeCells('J61:K61');
                $sheet->setCellValue('L61', 'Tanda Tangan');

                $sheet->mergeCells('A62:D65');
                $sheet->mergeCells('E62:E65');
                $sheet->mergeCells('F62:G65');
                $sheet->mergeCells('H62:I65');
                $sheet->mergeCells('J62:K65');
                $sheet->mergeCells('L62:L65');
            },
        ];
    }
}
