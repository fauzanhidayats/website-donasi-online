<?php

namespace App\Http\Controllers\Pimpinan;

use PDF;
use Illuminate\Http\Request;
use App\Models\PengajuanDonasi;
use App\Http\Controllers\Controller;

class LaporanPimpinanPengajuanController extends Controller
{
    public function index()
    {
        return view('pimpinan.laporan-pengajuan.index');
    }

    public function laporanPengajuan(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $pengajuan = PengajuanDonasi::whereBetween('tanggal_pengajuan', [$request->tanggal_mulai, $request->tanggal_selesai])
            ->with('user') // relasi yang sesuai
            ->get();

        return view('pimpinan.laporan-pengajuan.pengajuan', compact('pengajuan'));
    }

    public function cetakPengajuanPDF(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $pengajuan = PengajuanDonasi::whereBetween('tanggal_pengajuan', [$request->tanggal_mulai, $request->tanggal_selesai])
            ->with('user')
            ->get();

        $pdf = PDF::loadView('pimpinan.laporan-pengajuan.pdf_pengajuan', [
            'pengajuan' => $pengajuan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);

        return $pdf->download('laporan-pengajuan-donasi.pdf');
    }
}
