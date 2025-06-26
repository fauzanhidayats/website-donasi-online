<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PengajuanDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('pengajuan')->latest()->get();
        return view('admin.event.index', compact('events'));
    }

    public function create()
    {
        $pengajuans = PengajuanDonasi::where('status_pengajuan', 'disetujui')->get();
        return view('admin.event.create', compact('pengajuans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_event'      => 'required|string|max:100',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'target_donasi'   => 'required|numeric|min:0',
            'pengajuan_id'    => 'nullable|exists:pengajuan_donasi,id',
            'foto_event'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto_event')) {
            $validated['foto_event'] = $request->file('foto_event')->store('foto-event', 'public');
        }

        Event::create($validated);

        return redirect()->route('event.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function show($id)
    {
        $event = Event::with('pengajuan')->findOrFail($id);
        return view('admin.event.detail', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $pengajuanList = PengajuanDonasi::where('status_pengajuan', 'disetujui')->get();
        return view('admin.event.edit', compact('event', 'pengajuanList'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'nama_event'      => 'required|string|max:100',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'target_donasi'   => 'required|numeric|min:0',
            'pengajuan_id'    => 'nullable|exists:pengajuan_donasi,id',
            'foto_event'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto_event')) {
            if ($event->foto_event && Storage::disk('public')->exists($event->foto_event)) {
                Storage::disk('public')->delete($event->foto_event);
            }
            $validated['foto_event'] = $request->file('foto_event')->store('foto-event', 'public');
        }

        $event->update($validated);

        return redirect()->route('event.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->foto_event && Storage::disk('public')->exists($event->foto_event)) {
            Storage::disk('public')->delete($event->foto_event);
        }

        $event->delete();

        return redirect()->route('event.index')->with('success', 'Event berhasil dihapus.');
    }
}
