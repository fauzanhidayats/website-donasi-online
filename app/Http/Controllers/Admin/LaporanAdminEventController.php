<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanAdminEventController extends Controller
{
    public function index()
    {
        return view('admin.laporan-event.index');
    }

    public function laporanEvent(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $event = Event::whereBetween('created_at', [$request->tanggal_mulai, $request->tanggal_selesai])
            ->with(['pengajuan', 'donasi']) // relasi yang sesuai
            ->get();

        return view('admin.laporan-event.event', compact('event'));
    }

    public function cetakEventPDF(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $event = Event::whereBetween('created_at', [$request->tanggal_mulai, $request->tanggal_selesai])
            ->with(['pengajuan', 'donasi'])
            ->get();

        $pdf = PDF::loadView('admin.laporan-event.pdf_event', [
            'event' => $event,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);

        return $pdf->download('laporan-event.pdf');
    }
}
