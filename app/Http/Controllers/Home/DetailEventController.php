<?php

namespace App\Http\Controllers\Home;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DetailEventController extends Controller
{
    public function show($id)
    {

        $event = Event::withSum(['donasi as donasis_sum_nominal_donasi' => function ($query) {
            $query->where('status_pembayaran', 'berhasil');
        }], 'jumlah_donasi')->findOrFail($id);

        return view('front-end.detail-event', compact('event'));
    }
}
