<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\Request;

class DataDonasiController extends Controller
{
    public function index()
    {
        $donasi = Donasi::with(['user', 'event', 'pengajuan'])
            ->orderBy('tanggal_donasi', 'desc')
            ->get();

        return view('admin.donasi.index', compact('donasi'));
    }
}
