<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Support\Facades\Auth;

class DonasiUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $donasi = Donasi::where('user_id', $user->id)
            ->orderBy('tanggal_donasi', 'desc')
            ->get();

        return view('donatur.donasi.index', compact('donasi'));
    }
}
