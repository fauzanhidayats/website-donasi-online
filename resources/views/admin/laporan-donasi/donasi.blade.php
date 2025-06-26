@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Laporan Data Donasi</h1>
        </div>

        <form action="{{ route('admin.laporan.donasi.pdf') }}" method="GET" target="_blank">
            <input type="hidden" name="event_id" value="{{ request('event_id') }}">
            <input type="hidden" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
            <input type="hidden" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
            <button class="btn btn-danger mb-3">Cetak PDF</button>
        </form>

        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>Nama Donatur</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Jumlah Donasi</th>
                    <th>Metode Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Tanggal Donasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($donasi as $item)
                    <tr>
                        <td>{{ $item->nama_donatur ?? '-' }}</td>
                        <td>{{ $item->email_donatur ?? '-' }}</td>
                        <td>{{ $item->no_hp_donatur ?? '-' }}</td>
                        <td>Rp {{ number_format($item->jumlah_donasi, 0, ',', '.') }}</td>
                        <td>{{ $item->metode_pembayaran ?? '-' }}</td>
                        <td class="text-center">
                            @if ($item->status_pembayaran === 'berhasil')
                                <span class="badge badge-success">Berhasil</span>
                            @elseif ($item->status_pembayaran === 'gagal')
                                <span class="badge badge-danger">Gagal</span>
                            @else
                                <span class="badge badge-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_donasi)->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data donasi dalam rentang tanggal ini.</td>
                    </tr>
                @endforelse
            </tbody>

            @if ($donasi->count() > 0)
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="4" class="text-right">
                            <strong>Total Donasi: Rp {{ number_format($totalDonasi, 0, ',', '.') }}</strong>
                        </td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </section>
@endsection
