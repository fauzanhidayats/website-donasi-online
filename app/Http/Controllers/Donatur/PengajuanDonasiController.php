<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\PengajuanDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanDonasiController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanDonasi::where('user_id', Auth::id())
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        return view('donatur.pengajuan-donasi.index', compact('pengajuan'));
    }

    public function create()
    {
        return view('front-end.pengajuan-donasi');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'judul_pengajuan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'target_pengajuan' => 'required|numeric|min:1',
        ]);

        $buktiPath = $request->file('bukti')?->store('bukti_pengajuan', 'public');

        PengajuanDonasi::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'judul_pengajuan' => $request->judul_pengajuan,
            'deskripsi' => $request->deskripsi,
            'bukti' => $buktiPath,
            'target_pengajuan' => $request->target_pengajuan,
            'status_pengajuan' => 'diajukan',
            'tanggal_pengajuan' => now(),
        ]);

        return redirect()->route('pengajuan-donasi.index')->with('success', 'Pengajuan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $pengajuan = PengajuanDonasi::where('user_id', Auth::id())->findOrFail($id);
        return view('donatur.pengajuan-donasi.detail', compact('pengajuan'));
    }

    // public function edit($id)
    // {
    //     $pengajuan = PengajuanDonasi::where('user_id', Auth::id())->findOrFail($id);
    //     return view('pengajuan_donasi.edit', compact('pengajuan'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $pengajuan = PengajuanDonasi::where('user_id', Auth::id())->findOrFail($id);

    //     $request->validate([
    //         'nama' => 'nullable|string|max:100',
    //         'email' => 'nullable|email|max:100',
    //         'no_telp' => 'nullable|string|max:20',
    //         'alamat' => 'nullable|string',
    //         'judul_pengajuan' => 'required|string|max:100',
    //         'deskripsi' => 'nullable|string',
    //         'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //         'target_pengajuan' => 'required|numeric|min:1',
    //     ]);

    //     if ($request->hasFile('bukti')) {
    //         if ($pengajuan->bukti) {
    //             Storage::disk('public')->delete($pengajuan->bukti);
    //         }
    //         $pengajuan->bukti = $request->file('bukti')->store('bukti_pengajuan', 'public');
    //     }

    //     $pengajuan->update([
    //         'nama' => $request->nama,
    //         'email' => $request->email,
    //         'no_telp' => $request->no_telp,
    //         'alamat' => $request->alamat,
    //         'judul_pengajuan' => $request->judul_pengajuan,
    //         'deskripsi' => $request->deskripsi,
    //         'target_pengajuan' => $request->target_pengajuan,
    //     ]);

    //     return redirect()->route('pengajuan-donasi.index')->with('success', 'Pengajuan berhasil diperbarui.');
    // }

    // public function destroy($id)
    // {
    //     $pengajuan = PengajuanDonasi::where('user_id', Auth::id())->findOrFail($id);

    //     if ($pengajuan->bukti) {
    //         Storage::disk('public')->delete($pengajuan->bukti);
    //     }

    //     $pengajuan->delete();

    //     return redirect()->route('pengajuan-donasi.index')->with('success', 'Pengajuan berhasil dihapus.');
    // }
}
