<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Donasi;
use Illuminate\Http\Request;
use App\Models\PengajuanDonasi;

class DashboardPimpinanController extends Controller
{
    public function index()
    {

        $totalEvent = Event::count();

        // Total Donatur (unik berdasarkan nama/email/atau id donatur, contoh pakai email sebagai identifikasi)
        // Kalau di tabel donasi gak ada email, tapi ada nama_donatur dan user_id, kita bisa hitung unik kombinasi user_id + nama_donatur untuk menghitung donatur unik
        // Anggap ada kolom email_donatur di tabel donasi, jika tidak, bisa disesuaikan

        // Contoh hitung donatur unik berdasarkan user_id + nama_donatur
        $totalDonatur = Donasi::selectRaw('COALESCE(user_id, 0) as uid, nama_donatur')
            ->distinct()
            ->count();

        // Total Donasi (hanya status pembayaran berhasil)
        $totalDonasi = Donasi::where('status_pembayaran', 'berhasil')
            ->sum('jumlah_donasi');

        // Total Pengajuan Donasi
        $totalPengajuan = PengajuanDonasi::count();

        // Total User
        $totalUser = User::count();

        return view('pimpinan.dashboard', compact(
            'totalEvent',
            'totalDonatur',
            'totalDonasi',
            'totalPengajuan',
            'totalUser'
        ));
    }
}
