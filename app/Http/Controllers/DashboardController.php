<?php

namespace App\Http\Controllers;

use App\Models\perencanaan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $perencanaan = perencanaan::whereIn('status', ['Diajukan', 'approved'])->latest()->first();

        if ($perencanaan) {
            $badanUsaha = $perencanaan->badanUsaha;
            $badanUsaha->transform(function ($item) {
                $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
                return $item;
            });
        } else {
            $badanUsaha = collect();
        }
        return view('pages.dashboard.index', compact('perencanaan', 'badanUsaha'));
    }
}
