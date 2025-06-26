<?php

namespace App\Http\Controllers\Home;

use App\Models\Event;
use App\Models\Donasi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::withSum(['donasi as donasis_sum_nominal_donasi' => function ($query) {
            $query->where('status_pembayaran', 'berhasil');
        }], 'jumlah_donasi')
            ->latest()
            ->take(6)
            ->get();

        $totalDana = Donasi::where('status_pembayaran', 'berhasil')->sum('jumlah_donasi');

        $totalDonaturLogin = Donasi::whereNotNull('user_id')
            ->where('status_pembayaran', 'berhasil')
            ->distinct('user_id')
            ->count('user_id');

        $totalDonaturAnonim = Donasi::whereNull('user_id')
            ->where('status_pembayaran', 'berhasil')
            ->distinct('email_donatur') // bisa juga pakai 'nama_donatur' atau 'no_hp_donatur'
            ->count('email_donatur');

        $totalDonatur = $totalDonaturLogin + $totalDonaturAnonim;

        $totalEvents = Event::count();

        return view('front-end.index', compact('events', 'totalDana', 'totalDonatur', 'totalEvents'));
    }
}
