<?php

namespace App\Exports;

use App\Models\BadanUsaha;
use App\Models\employee_roles;
use App\Models\perencanaan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class BadanUsahaExport implements FromCollection, ShouldAutoSize, WithStyles, WithEvents
{
    private $startDate;
    private $endDate;
    private $lastPerencanaan;
    private $badanUsaha;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($startDate, $endDate, $lastPerencanaan, $badanUsaha)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->lastPerencanaan = $lastPerencanaan;
        $this->badanUsaha = $badanUsaha;
    }
    public function collection()
    {
        $data = BadanUsaha::where('id', $this->badanUsaha->id)->get();

        $data = collect([]);
        return $data;
    }


    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:M1');
        $sheet->mergeCells('A2:M2');

        $sheet->mergeCells('A3:A4');
        $sheet->mergeCells('B3:B4');
        $sheet->mergeCells('C3:C4');
        $sheet->mergeCells('D3:D4');
        $sheet->mergeCells('E3:E4');
        $sheet->mergeCells('F3:F4');
        $sheet->mergeCells('G3:I3');
        $sheet->mergeCells('J3:K3');
        $sheet->mergeCells('L3:M3');

        $sheet->getColumnDimension('A')->setWidth(3); // No
        $sheet->getColumnDimension('B')->setWidth(37); // Nama Badan Usaha
        $sheet->getColumnDimension('C')->setWidth(10); // Kode Badan Usaha
        $sheet->getrowDimension('4')->setRowHeight(29);
        $sheet->getColumnDimension('D')->setWidth(27); // Alamat
        $sheet->getColumnDimension('E')->setWidth(20); // Kota/Kab
        $sheet->getColumnDimension('F')->setWidth(18); // Jenis Ketidakpatuhan
        $sheet->getColumnDimension('G')->setWidth(18); // Tanggal Terakhir Bayar
        $sheet->getColumnDimension('H')->setWidth(18); // Jumlah Tunggakan
        $sheet->getColumnDimension('I')->setWidth(18); // Jenis Pemeriksaan
        $sheet->getColumnDimension('J')->setWidth(16); // Jadwal Pemeriksaan 
        $sheet->getColumnDimension('K')->setWidth(16); // Jadwal Pemeriksaan 
        $sheet->getColumnDimension('L')->setWidth(19); // Jadwal Pemeriksaan 
        $sheet->getColumnDimension('M')->setWidth(28); // Jadwal Pemeriksaan 

        $sheet->getStyle('A3:M4')->getAlignment()->setVertical('center')->setHorizontal('center');

        $sheet->getStyle('A3:M4')->getBorders()->getAllBorders()->setBorderStyle('thin');
        $sheet->getStyle('A3:M4')->getFont()->setBold(true);




        $sheet->getStyle('A3:M3')->getAlignment()->setWrapText(true);
        return [
            // Style untuk heading
            'A1:M2' => [
                'font' => [
                    'bold' => true, // Tebal (bold)
                ],
                'alignment' => [
                    'horizontal' => 'center', // Tengah (center)
                    'vertical' => 'center',     // Tengah (center)
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => 'thin', // Jenis garis tipis
                        'color' => ['argb' => '000000'], // Warna hitam
                    ],
                ],
            ],
        ];
    }
    public function registerEvents(): array
    {
        $row = 5;
        $perencanaan = perencanaan::latest()->first();
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        if (empty($startDate)) {
            $startDate = now()->toDateString(); // Mengambil tanggal hari ini sebagai default
        }
        return [
            AfterSheet::class => function (AfterSheet $event) use ($startDate, $endDate, $row) {
                $sheet = $event->sheet;
                // Mengatur judul "PERENCANAAN PEMERIKSAAN"
                $sheet->setCellValue('A1', 'PERENCANAAN PEMERIKSAAN');

                // Mengubah format tanggal awal dan tanggal akhir
                $carbonStartDate = Carbon::createFromFormat('Y-m-d', $startDate);
                $carbonEndDate = Carbon::createFromFormat('Y-m-d', $endDate);

                $formattedStartDate = $carbonStartDate->locale('id')->isoFormat('dddd, DD-MM-YYYY');
                $formattedEndDate = $carbonEndDate->locale('id')->isoFormat('dddd, DD-MM-YYYY');

                $sheet->setCellValue('A2', "$formattedStartDate - $formattedEndDate");


                // Mengatur nama kolom
                $sheet->setCellValue('A3', 'No');
                $sheet->setCellValue('B3', 'Nama Badan Usaha');
                $sheet->setCellValue('C3', 'Kode Badan Usaha');
                $sheet->setCellValue('D3', 'Alamat');
                $sheet->setCellValue('E3', 'Kota/Kab');
                $sheet->setCellValue('F3', 'Jenis Ketidakpatuhan');
                $sheet->setCellValue('G3', 'Urgensi');
                $sheet->setCellValue('G4', 'MF');
                $sheet->setCellValue('H4', 'Potensi');
                $sheet->setCellValue('I4', 'Jumlah Tunggakan');
                $sheet->setCellValue('J3', 'Jenis Pemeriksaan');
                $sheet->setCellValue('J4', 'Kantor');
                $sheet->setCellValue('K4', 'Lapangan');
                $sheet->setCellValue('L3', 'Jadwal Pemeriksaan');
                $sheet->setCellValue('L4', 'Pelaksanaan');
                $sheet->setCellValue('M4', 'Penerbitan LHPA');



                // Data dimulai dari baris ke-4

                $perencanaan = perencanaan::latest()->first();
                $badanUsaha = BadanUsaha::where('perencanaan_id', $perencanaan->id)->get();



                $totalTunggakan = 0; // Inisialisasi total tunggakan
                $no = 1; // Inisialisasi nomor urutan

                foreach ($badanUsaha as $data) {

                    // Menghitung total tunggakan
                    $totalTunggakan += floatval($data->jumlah_tunggakan);

                    $sheet->setCellValue('A' . $row, $no);
                    $sheet->setCellValue('B' . $row, $data->nama_badan_usaha);
                    $sheet->setCellValue('C' . $row, $data->kode_badan_usaha);
                    $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal('center');
                    $sheet->setCellValue('D' . $row, $data->alamat);
                    $sheet->setCellValue('E' . $row, $data->kota_kab);
                    $sheet->setCellValue('F' . $row, $data->jenis_ketidakpatuhan);
                    $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal('center');
                    $sheet->setCellValue('I' . $row, 'Rp ' . number_format($data->jumlah_tunggakan, 2, ',', '.'));
                    if ($data->jenis_pemeriksaan == 'Kantor') {
                        $sheet->setCellValue('J' . $row, 'Kantor');
                        $sheet->setCellValue('K' . $row, '-');
                        $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal('center');
                    } elseif ($data->jenis_pemeriksaan == 'Lapangan') {
                        $sheet->setCellValue('J' . $row, '-');
                        $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal('center');
                        $sheet->setCellValue('K' . $row, 'Lapangan');
                    }
                    $jadwalPemeriksaan = Carbon::createFromFormat('Y-m-d', $data->jadwal_pemeriksaan);
                    $formattedJadwal = $jadwalPemeriksaan->locale('id')->isoFormat('dddd, D MMMM YYYY');
                    $sheet->setCellValue('L' . $row, $formattedJadwal);
                    $sheet->getStyle('A' . $row . ':M' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->getStyle('A3:J3')->getAlignment()->setVertical('center'); // Posisi tengah vertical
                    $sheet->getStyle('A' . $row . ':M' . $row)->getFont()->setSize(9);
                    $lastRow = $row; // Simpan nomor baris terakhir dari data Badan Usaha
                    $row++;


                    $no++;
                }
                $mergeRange = 'G' . ($lastRow - count($badanUsaha) + 1) . ':H' . $lastRow;
                $sheet->mergeCells($mergeRange);
                $sheet->setCellValue('G' . ($lastRow - count($badanUsaha) + 1), 'Diisi untuk pemeriksaan kepatuhan pendaftaran/penyampaian data');
                $sheet->getStyle('A3:J' . $lastRow)->getAlignment()->setWrapText(true);
                $mergeCell = 'G' . ($lastRow - count($badanUsaha) + 1);
                $sheet->setCellValue($mergeCell, 'Diisi untuk pemeriksaan kepatuhan pendaftaran/penyampaian data');
                $sheet->getStyle($mergeCell)->getAlignment()->setHorizontal('center');
                $sheet->getStyle($mergeCell)->getAlignment()->setVertical('center');

                $sheet->setCellValue('B' . ($lastRow + 1), 'Total');
                $sheet->setCellValue('I' . ($lastRow + 1), 'Rp ' . number_format($totalTunggakan, 2, ',', '.')); // Ganti $totalTunggakan dengan nilai total yang sesuai

                // Merge kolom B sampai H
                $sheet->mergeCells('B' . ($lastRow + 1) . ':H' . ($lastRow + 1));
                $sheet->getStyle('B' . ($lastRow + 1) . ':H' . ($lastRow + 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
                // Set warna background dan teks yang di-bold untuk kolom B sampai H
                $sheet->getStyle('B' . ($lastRow + 1) . ':H' . ($lastRow + 1))->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => '92D050',
                        ],
                    ],
                    'font' => [
                        'bold' => true,
                    ],

                    'alignment' => [
                        'horizontal' => 'center',
                    ],
                ]);

                // Merge kolom I sampai M
                $sheet->mergeCells('I' . ($lastRow + 1) . ':M' . ($lastRow + 1));
                $sheet->getStyle('I' . ($lastRow + 1) . ':M' . ($lastRow + 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
                // Set warna background dan teks yang di-bold untuk kolom I sampai M
                $sheet->getStyle('I' . ($lastRow + 1) . ':M' . ($lastRow + 1))->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => '92D050',
                        ],
                    ],
                    'font' => [
                        'bold' => true,
                    ],

                ]);
                $sheet->setCellValue('A' . ($lastRow + 3), 'Catatan Kepala Bagian:'); // Isi dengan teks catatan pemeriksa
                $sheet->mergeCells('A' . ($lastRow + 3) . ':M' . ($lastRow + 3)); // Gabung sel untuk catatan pemeriksa
                $sheet->getStyle('A' . ($lastRow + 3) . ':M' . ($lastRow + 3))->getAlignment()->setHorizontal('center'); // Rata tengah horizontal untuk catatan pemeriksa
                $sheet->getStyle('A' . ($lastRow + 3) . ':M' . ($lastRow + 3))->getAlignment()->setVertical('center'); // Posisi tengah vertical untuk catatan pemeriksa
                $sheet->getStyle('A' . ($lastRow + 3) . ':M' . ($lastRow + 3))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // Tambahkan dua kolom di bawah catatan pemeriksa dan gabungkan dari kolom A sampai J
                $sheet->mergeCells('A' . ($lastRow + 4) . ':M' . ($lastRow + 5)); // Gabung dua kolom di bawah catatan pemeriksa dari kolom A sampai J
                $sheet->getStyle('A' . ($lastRow + 4) . ':M' . ($lastRow + 5))->getAlignment()->setHorizontal('center'); // Rata tengah horizontal untuk kolom 1 dan kolom 2
                $sheet->getStyle('A' . ($lastRow + 4) . ':M' . ($lastRow + 5))->getAlignment()->setVertical('center'); // Posisi tengah vertical untuk kolom 1 dan kolom 2
                $sheet->getStyle('A' . ($lastRow + 4) . ':M' . ($lastRow + 5))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                //style untuk catatan kepala bagian
                $sheet->getStyle('A' . ($lastRow + 3) . ':M' . ($lastRow + 3))->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'A6A6A6',
                        ],
                    ],
                    'font' => [
                        'bold' => true, // Mengatur teks menjadi tebal
                        'color' => [
                            'rgb' => '000000', // Mengatur warna teks menjadi putih
                        ],
                    ],
                ]);

                $sheet->setCellValue('A' . ($lastRow + 6), 'Catatan Kepala Cabang:'); // Isi dengan teks catatan pemeriksa
                $sheet->mergeCells('A' . ($lastRow + 6) . ':M' . ($lastRow + 6)); // Gabung sel untuk catatan pemeriksa
                $sheet->getStyle('A' . ($lastRow + 6) . ':M' . ($lastRow + 6))->getAlignment()->setHorizontal('center'); // Rata tengah horizontal untuk catatan pemeriksa
                $sheet->getStyle('A' . ($lastRow + 6) . ':M' . ($lastRow + 6))->getAlignment()->setVertical('center'); // Posisi tengah vertical untuk catatan pemeriksa
                $sheet->getStyle('A' . ($lastRow + 6) . ':M' . ($lastRow + 6))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // Tambahkan dua kolom di bawah catatan pemeriksa dan gabungkan dari kolom A sampai J
                $sheet->mergeCells('A' . ($lastRow + 7) . ':M' . ($lastRow + 8)); // Gabung dua kolom di bawah catatan pemeriksa dari kolom A sampai J
                $sheet->getStyle('A' . ($lastRow + 7) . ':M' . ($lastRow + 8))->getAlignment()->setHorizontal('center'); // Rata tengah horizontal untuk kolom 1 dan kolom 2
                $sheet->getStyle('A' . ($lastRow + 7) . ':M' . ($lastRow + 8))->getAlignment()->setVertical('center'); // Posisi tengah vertical untuk kolom 1 dan kolom 2
                $sheet->getStyle('A' . ($lastRow + 7) . ':M' . ($lastRow + 8))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                //style untuk catatan kepala bagian
                $sheet->getStyle('A' . ($lastRow + 6) . ':M' . ($lastRow + 6))->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'A6A6A6',
                        ],
                    ],
                    'font' => [
                        'bold' => true, // Mengatur teks menjadi tebal
                        'color' => [
                            'rgb' => '000000', // Mengatur warna teks menjadi putih
                        ],
                    ],
                ]);
                $employeeRoles = employee_roles::whereIn('posisi', ['Tim Pemeriksa', 'Kepala Bagian', 'Kepala Cabang'])->get();
                

                $sheet->setCellValue('G' . ($lastRow + 10), 'Nama'); // Isi dengan teks catatan pemeriksa
                $sheet->setCellValue('I' . ($lastRow + 10), 'Tanda Tangan'); // Isi dengan teks catatan pemeriksa
                $sheet->setCellValue('K' . ($lastRow + 10), 'Tanggal'); // Isi dengan teks catatan pemeriksa
                $sheet->setCellValue('F' . ($lastRow + 11), 'Disusun Oleh : ' . chr(10) . 'PetuFas Pemeriksa'); // Isi denFan teks catatan pemeriksa
                $sheet->setCellValue('G' . ($lastRow + 11), $employeeRoles[0]->nama); // Isi deGgan teks catatan pemeriksG
                $sheet->setCellValue('F' . ($lastRow + 12), 'Direviu Oleh : ' . chr(10) . ' Kepala Bagian'); // Isi dengan teks catatan pemeriksa
                $sheet->setCellValue('G' . ($lastRow + 12), $employeeRoles[1]->nama); // Isi dengan teks catatan pemeriksa
                $sheet->setCellValue('F' . ($lastRow + 13), 'Disetujui Oleh : ' . chr(10) . 'Pps Kepala Cabang'); // Isi dengan teks catatan pemeriksa
                $sheet->setCellValue('G' . ($lastRow + 13), $employeeRoles[2]->nama); // Isi dengan teks catatan pemeriksa
                $sheet->getStyle('F' . ($lastRow + 10) . ':K' . ($lastRow + 13))->getAlignment()->setHorizontal('center'); // Rata tengah horizontal untuk catatan pemeriksa
                $sheet->getStyle('F' . ($lastRow + 10) . ':K' . ($lastRow + 13))->getAlignment()->setVertical('center'); // Posisi tengah vertical untuk catatan pemeriksa
                $sheet->getStyle('F' . ($lastRow + 10) . ':K' . ($lastRow + 13))->getAlignment()->setWrapText(true); // Posisi tengah vertical untuk catatan pemeriksa
                $sheet->getStyle('F' . ($lastRow + 10) . ':K' . ($lastRow + 13))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('F' . ($lastRow + 10) . ':K' . ($lastRow + 10))->getFont()->setSize(10);
            },
        ];
    }
}
