@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Laporan Data Pengajuan Donasi</h1>
        </div>

        <form action="{{ route('admin.laporan.pengajuan.pdf') }}" method="GET" target="_blank">
            <input type="hidden" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
            <input type="hidden" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
            <button class="btn btn-danger mb-3">Cetak PDF</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Telp</th>
                    <th>Judul Pengajuan</th>
                    <th>Target Pengajuan</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengajuan as $item)
                    <tr>
                        <td>{{ $item->nama ?? '-' }}</td>
                        <td>{{ $item->email ?? '-' }}</td>
                        <td>{{ $item->no_telp ?? '-' }}</td>
                        <td>{{ $item->judul_pengajuan }}</td>
                        <td>Rp {{ number_format($item->target_pengajuan, 0, ',', '.') }}</td>
                        <td>
                            @if ($item->status_pengajuan === 'disetujui')
                                <span class="btn btn-success btn-sm">Disetujui</span>
                            @elseif ($item->status_pengajuan === 'ditolak')
                                <span class="btn btn-danger btn-sm">Ditolak</span>
                            @else
                                <span class="btn btn-warning btn-sm">Diajukan</span>
                            @endif
                        </td>

                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data pengajuan dalam rentang tanggal ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
