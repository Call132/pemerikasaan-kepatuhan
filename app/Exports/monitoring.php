<?php

namespace App\Exports;

use App\Models\BadanUsaha;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class monitoring implements FromCollection, WithStyles, WithEvents
{
    protected $badanUsaha, $perencanaan;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($badanUsaha, $perencanaan)
    {
        $this->badanUsaha = $badanUsaha;
        $this->perencanaan = $perencanaan;
    }

    public function collection()
    {
        $data = BadanUsaha::where('id', $this->badanUsaha->id)->get();

        $data = collect([]);
        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:L27')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:L27')->getFont()->setName('Arial');
        $sheet->getStyle('A1:L27')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:L27')->getAlignment()->setVertical('center');
        $sheet->getStyle('A17:L27')->getFont()->setSize(10);
        $sheet->getStyle('A1:L1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A1:L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');
        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(17);
        $sheet->getColumnDimension('D')->setWidth(17);
        $sheet->getColumnDimension('E')->setWidth(17);
        $sheet->getColumnDimension('F')->setWidth(17);
        $sheet->getColumnDimension('G')->setWidth(16);
        $sheet->getColumnDimension('H')->setWidth(17);
        $sheet->getColumnDimension('I')->setWidth(17);
        $sheet->getColumnDimension('J')->setWidth(17);
        $sheet->getColumnDimension('K')->setWidth(22);
        $sheet->getColumnDimension('L')->setWidth(12);



        return [];
    }

    public function registerEvents(): array
    {
        $row = 2;

        return [
            AfterSheet::class => function (AfterSheet $event) use ($row) {
                $sheet = $event->sheet;

                $sheet->setCellValue('A1', 'No');
                $sheet->setCellValue('B1', 'Tanggal Pemeriksaan');
                $sheet->setCellValue('C1', 'Nama Badan Usaha');
                $sheet->setCellValue('D1', 'Kode Badan Usaha');
                $sheet->setCellValue('E1', 'Alamat');
                $sheet->setCellValue('F1', 'Tanggal Terakhir Bayar');
                $sheet->setCellValue('G1', 'Jumlah Bulan Menunggak');
                $sheet->setCellValue('H1', 'Jumlah Tunggakan');
                $sheet->setCellValue('I1', 'Tanggal Bayar');
                $sheet->setCellValue('J1', 'Jumlah Bayar');
                $sheet->setCellValue('K1', 'Hasil Pemeriksaan');
                $sheet->setCellValue('L1', 'Persentase');

                $perencanaan = $this->perencanaan;

                $badanUsaha = BadanUsaha::where('perencanaan_id', $perencanaan->id)->get();


                $totalTunggakan = 0;
                $totalBayar = 0;
                $no = 1;

                foreach ($badanUsaha as $data) {
                    $sheet->setCellValue('A' . $row, $no);
                    $sheet->setCellValue('B' . $row, $data->jadwal_pemeriksaan);
                    $sheet->setCellValue('C' . $row, $data->nama_badan_usaha);
                    $sheet->setCellValue('D' . $row, $data->kode_badan_usaha);
                    $sheet->setCellValue('E' . $row, $data->alamat);
                    $sheet->setCellValue('F' . $row, $data->tanggal_terakhir_bayar);
                    $sheet->setCellValue('G' . $row, $data->jumlah_bulan_menunggak . ' (Bulan)');
                    $sheet->setCellValue('H' . $row, 'Rp. ' . number_format($data->jumlah_tunggakan, 2, ',', '.'));
                    $sheet->setCellValue('I' . $row, $data->tanggal_bayar);
                    $sheet->setCellValue('J' . $row, 'Rp. ' . number_format($data->jumlah_bayar, 2, ',', '.'));
                    $sheet->setCellValue('K' . $row, $data->hasil_pemeriksaan);
                    $sheet->setCellValue('L' . $row, number_format($data->jumlah_tunggakan != 0 ? ($data->jumlah_bayar / $data->jumlah_tunggakan) * 100 : 'N/A', 0) . '%');
                    $sheet->getStyle('A' . $row . ':L' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                    $lastRow = $row;
                    $row++;
                    $no++;
                    $totalTunggakan += $data->jumlah_tunggakan;
                    $totalBayar += $data->jumlah_bayar;
                }

                $sheet->setCellValue('B' . ($lastRow + 1), 'Total');
                $sheet->setCellValue('H' . ($lastRow + 1), 'Rp ' . number_format($totalTunggakan, 2, ',', '.'));
                $sheet->getStyle('H' . $lastRow + 1)->getAlignment()->setVertical('left');
                $sheet->setCellValue('J' . ($lastRow + 1), 'Rp ' . number_format($totalBayar, 2, ',', '.'));
                $sheet->getStyle('J' . $lastRow + 1)->getAlignment()->setVertical('left');
                $sheet->setCellValue('L' . ($lastRow + 1), number_format($totalTunggakan != 0 ? ($totalBayar / $totalTunggakan) * 100 : 'N/A', 0) . '%');
                $sheet->getStyle('A' . $lastRow + 1 . ':L' . $lastRow + 1)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->mergeCells('B' . $lastRow + 1 . ':G' . $lastRow + 1);
                $sheet->mergeCells('H' . $lastRow + 1 . ':I' . $lastRow + 1);
                $sheet->mergeCells('J' . $lastRow + 1 . ':K' . $lastRow + 1);
                $sheet->getStyle('A' . $lastRow + 1 . ':L' . $lastRow + 1)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('92D050');
                $sheet->getStyle('A' . $lastRow + 1 . ':L' . $lastRow + 1)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);;
            }

        ];
    }
}
