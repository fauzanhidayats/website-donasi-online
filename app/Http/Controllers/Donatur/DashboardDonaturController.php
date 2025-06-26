<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donasi;
use App\Models\PengajuanDonasi;

class DashboardDonaturController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Total nominal donasi user (baik yang user_id = $user->id, atau user_id null, 
        // tapi di sini fokus user yg login)
        $totalDonasi = Donasi::where('user_id', $user->id)
            ->where('status_pembayaran', 'berhasil')
            ->sum('jumlah_donasi');

        // Total pengajuan yang user ajukan sendiri (count pengajuan berdasarkan user_id)
        $totalPengajuan = PengajuanDonasi::where('user_id', $user->id)->count();

        return view('donatur.dashboard', compact('totalDonasi', 'totalPengajuan'));
    }
}
