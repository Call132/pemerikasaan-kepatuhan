<?php

namespace App\Exports;

use App\Models\BadanUsaha;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BadanUsahaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BadanUsaha::all()->map(function ($item){
            unset($item['created_at']);
            unset($item['updated_at']);
            
            return $item;
        });
    }
    public function styles(Worksheet $sheet)
{
    return [
        // Style untuk heading
        'A1:J1' => [
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
public function view(): View
    {
        $data = BadanUsaha::all()->map(function ($item){
            unset($item['created_at']);
            unset($item['updated_at']);
            
            return $item;
        });

        return view('export.badan_usaha', [
            'data' => $data,
        ]);
    }
    public function registerEvents(): array
    
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Mengatur judul "PERENCANAAN PEMERIKSAAN"
            $event->sheet->setCellValue('A1', 'PERENCANAAN PEMERIKSAAN');
            $event->sheet->mergeCells('A1:J1');
            $event->sheet->getStyle('A1')->getFont()->setBold(true);
            $event->sheet->getStyle('A1')->getFont()->setSize(11);                
            $event->sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                // Mengatur periode waktu "Hari, Tanggal Bulan Tahun - Hari, Tanggal Bulan Tahun"
            $event->sheet->setCellValue('A2', 'Hari, Tanggal Bulan Tahun - Hari, Tanggal Bulan Tahun');
            $event->sheet->mergeCells('A2:J2');
            $event->sheet->getStyle('A2')->getFont()->setBold(true);
            $event->sheet->getStyle('A2')->getFont()->setSize(10);                
            $event->sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                
                
            // Mengatur nama kolom
            $event->sheet->setCellValue('A3', 'No');
            $event->sheet->setCellValue('B3', 'Nama Badan Usaha');
            $event->sheet->setCellValue('C3', 'Kode Badan Usaha');
            $event->sheet->setCellValue('D3', 'Alamat');
            $event->sheet->setCellValue('E3', 'Kota/Kab');
            $event->sheet->setCellValue('F3', 'Jenis Ketidakpatuhan');
            $event->sheet->setCellValue('G3', 'Tanggal Terakhir Bayar');
            $event->sheet->setCellValue('H3', 'Jumlah Tunggakan');
            $event->sheet->setCellValue('I3', 'Jenis Pemeriksaan');
            $event->sheet->setCellValue('J3', 'Jadwal Pemeriksaan');

            // Mengatur format dan style pada baris nama kolom
            $event->sheet->getStyle('A3:J3')->getFont()->setBold(true);
            $event->sheet->getStyle('A3:J3')->getAlignment()->setHorizontal('center');
            $event->sheet->getStyle('A3:J3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            
            // Mengatur lebar kolom
            $event->sheet->getColumnDimension('A')->setWidth(5); // No
            $event->sheet->getColumnDimension('B')->setWidth(20); // Nama Badan Usaha
            $event->sheet->getColumnDimension('C')->setWidth(15); // Kode Badan Usaha
            $event->sheet->getColumnDimension('D')->setWidth(30); // Alamat
            $event->sheet->getColumnDimension('E')->setWidth(15); // Kota/Kab
            $event->sheet->getColumnDimension('F')->setWidth(20); // Jenis Ketidakpatuhan
            $event->sheet->getColumnDimension('G')->setWidth(20); // Tanggal Terakhir Bayar
            $event->sheet->getColumnDimension('H')->setWidth(20); // Jumlah Tunggakan
            $event->sheet->getColumnDimension('I')->setWidth(20); // Jenis Pemeriksaan
            $event->sheet->getColumnDimension('J')->setWidth(20); // Jadwal Pemeriksaan
            
            // Data dimulai dari baris ke-4
            $row = 4;
            $badanUsaha = BadanUsaha::all();
            $totalTunggakan = 0; // Inisialisasi total tunggakan

            foreach ($badanUsaha as $data) {
                // ...
                
                // Menghitung total tunggakan
                $totalTunggakan += floatval(str_replace(['Rp ', '.', ','], '', $data->jumlah_tunggakan));
                
                // ...
            }
            $no = 1; // Inisialisasi nomor urutan

            foreach ($badanUsaha as $data) {
                $event->sheet->setCellValue('A' . $row, $no); 
                $event->sheet->setCellValue('B' . $row, $data->nama_badan_usaha);
                $event->sheet->setCellValue('C' . $row, $data->kode_badan_usaha);
                $event->sheet->setCellValue('D' . $row, $data->alamat);
                $event->sheet->setCellValue('E' . $row, $data->kota_kab);
                $event->sheet->setCellValue('F' . $row, $data->jenis_ketidakpatuhan);
                $event->sheet->setCellValue('G' . $row, $data->tanggal_terakhir_bayar);
                $event->sheet->setCellValue('H' . $row, 'Rp ' . number_format(floatval(str_replace(['Rp ', '.', ','], '', $data->jumlah_tunggakan)), 2, ',', '.')); // Format rupiah
                $event->sheet->setCellValue('I' . $row, $data->jenis_pemeriksaan);
                $event->sheet->setCellValue('J' . $row, $data->jadwal_pemeriksaan);
                $lastRow = $row; // Simpan nomor baris terakhir dari data Badan Usaha
                $event->sheet->setCellValue('B' . ($lastRow + 1), 'Total');
                $event->sheet->setCellValue('H' . ($lastRow + 1), 'Rp ' . number_format($totalTunggakan, 2, ',', '.')); // Ganti $totalTunggakan dengan nilai total yang sesuai
                $event->sheet->getStyle('B' . $lastRow + 1 . ':J' . $lastRow + 1)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


                $event->sheet->getStyle('A' . $row . ':J' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $row++;
                $no++;

                // ...
               
                }

            },
        ];
    }



    public function headings(): array{
        return
        [
            'No',
            'Nama Badan Usaha',
            'Kode Badan Usaha',
            'Alamat',
            'Kota/Kab',
            'Jenis Ketidakpatuhan',
            'Tanggal Terakhir Bayar',
            'Jumlah Tunggakan',
            'Jenis Pemeriksaan',
            'Jadwal Pemeriksaan',   
        ];
    }
}
   