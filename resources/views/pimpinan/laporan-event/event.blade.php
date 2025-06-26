@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Laporan Data Event</h1>
        </div>

        <form action="{{ route('pimpinan.laporan.event.pdf') }}" method="GET" target="_blank">
            <input type="hidden" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
            <input type="hidden" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
            <button class="btn btn-danger mb-3">Cetak PDF</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Event</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Target Donasi</th>
                    <th>Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($event as $item)
                    <tr>
                        <td>{{ $item->nama_event ?? '-' }}</td>
                        <td>{{ $item->tanggal_mulai ?? '-' }}</td>
                        <td>{{ $item->tanggal_selesai ?? '-' }}</td>
                        <td>Rp {{ number_format($item->target_donasi, 0, ',', '.') ?? '-' }}</td>
                        <td>{{ $item->pengajuan->judul_pengajuan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data event dalam rentang tanggal ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
