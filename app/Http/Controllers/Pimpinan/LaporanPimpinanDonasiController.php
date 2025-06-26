<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donasi;
use App\Models\Event;
use PDF;

class LaporanPimpinanDonasiController extends Controller
{
    /**
     * Tampilkan form laporan donasi
     */
    public function index()
    {
        $events = Event::orderBy('nama_event')->get();
        return view('pimpinan.laporan-donasi.index', compact('events'));
    }

    /**
     * Cetak laporan donasi berdasarkan event dan tanggal
     */

    public function laporanDonasi(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $donasi = Donasi::with(['event', 'pengajuan'])
            ->where('event_id', $request->event_id)
            ->whereBetween('tanggal_donasi', [$request->tanggal_mulai, $request->tanggal_selesai])
            ->orderBy('tanggal_donasi', 'asc')
            ->get();

        $totalDonasi = $donasi->sum('jumlah_donasi');

        return view('pimpinan.laporan-donasi.donasi', compact('donasi', 'totalDonasi'));
    }

    public function cetakDonasiPDF(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $donasi = Donasi::with('event', 'pengajuan')
            ->where('event_id', $request->event_id)
            ->whereBetween('tanggal_donasi', [$request->tanggal_mulai, $request->tanggal_selesai])
            ->orderBy('tanggal_donasi', 'asc')
            ->get();

        $event = Event::find($request->event_id);
        $totalDonasi = $donasi->sum('jumlah_donasi');

        $pdf = PDF::loadView('pimpinan.laporan-donasi.pdf_donasi', [
            'donasi' => $donasi,
            'event' => $event,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'totalDonasi' => $totalDonasi
        ])->setPaper('A4', 'landscape');

        return $pdf->download('laporan-donasi.pdf');
    }
}
