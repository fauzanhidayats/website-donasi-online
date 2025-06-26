<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PengajuanDonasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengajuanDonasiStatusMail;

class PengajuanDonasiAdminController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanDonasi::orderBy('tanggal_pengajuan', 'desc')->get();
        return view('admin.pengajuan-donasi.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = PengajuanDonasi::findOrFail($id);
        return view('admin.pengajuan-donasi.detail', compact('pengajuan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pengajuan' => 'required|in:disetujui,ditolak',
        ]);

        $pengajuan = PengajuanDonasi::findOrFail($id);

        if ($pengajuan->status_pengajuan !== 'diajukan') {
            return redirect()->back()->with('error', 'Pengajuan sudah diproses sebelumnya.');
        }

        $pengajuan->update([
            'status_pengajuan' => $request->status_pengajuan,
        ]);

        // Kirim email notifikasi
        if (filter_var($pengajuan->email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($pengajuan->email)->send(new PengajuanDonasiStatusMail($pengajuan));
        }

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui dan email notifikasi terkirim.');
    }
}
