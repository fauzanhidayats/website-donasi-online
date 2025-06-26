<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class AllEventController extends Controller
{
    public function index()
    {
        $events = Event::withSum(['donasi as donasis_sum_nominal_donasi' => function ($query) {
            $query->where('status_pembayaran', 'berhasil');
        }], 'jumlah_donasi')
            ->latest()
            ->get(); // Ambil SEMUA event tanpa limit

        return view('front-end.all-event', compact('events'));
    }
}
