<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\perencanaan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function dashboard()
    {
        $type_menu = 'dashboard'; // Tipe menu sesuai dengan halaman dashboard
        return view('dashboard', compact('type_menu'));
    }

    public function index()
    {
        // Get the latest perencanaan with status "diajukan"
        $latestPerencanaan = Perencanaan::where('status', 'diajukan')
            ->latest()
            ->first();

        if ($latestPerencanaan) {
            // Retrieve the associated badan_usaha records
            $badanUsaha = $latestPerencanaan->badanUsaha;

            // Transform the data as needed
            $badanUsaha->transform(function ($item) {
                $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
                return $item;
            });

            // Define default start_date and end_date values
            $start_date = $latestPerencanaan->start_date;
            $end_date = $latestPerencanaan->end_date;
        } else {
            // If there is no "diajukan" perencanaan, set $badanUsaha to an empty collection
            $badanUsaha = collect();
            $latestPerencanaan = null; // Set $latestPerencanaan to null
            $start_date = null; // Set start_date and end_date to null
            $end_date = null;
        }

        return view('home', [
            'type_menu' => 'dashboard',
            'badanUsaha' => $badanUsaha,
            'latestPerencanaan' =>$latestPerencanaan,
            'latestPerencanaanId' => optional($latestPerencanaan)->id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
}
