<!DOCTYPE html>
<html>

<head>
    <title>Laporan Donasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            color: #fff;
        }

        .pending {
            background-color: #ffc107;
            color: #000;
        }

        .berhasil {
            background-color: #28a745;
        }

        .gagal {
            background-color: #dc3545;
        }
    </style>
</head>

<body>
    <h2>Laporan Donasi</h2>
    <p>Periode: {{ $tanggal_mulai }} s/d {{ $tanggal_selesai }}</p>
    <p>Event: {{ $event->nama_event ?? '-' }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama Donatur</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Judul Pengajuan</th>
                <th>Jumlah Donasi</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
                <th>Tanggal Donasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($donasi as $item)
                <tr>
                    <td>{{ $item->nama_donatur ?? '-' }}</td>
                    <td>{{ $item->email_donatur ?? '-' }}</td>
                    <td>{{ $item->no_hp_donatur ?? '-' }}</td>
                    <td>{{ $item->pengajuan->judul_pengajuan ?? '-' }}</td>
                    <td>Rp {{ number_format($item->jumlah_donasi, 0, ',', '.') }}</td>
                    <td>{{ $item->metode_pembayaran ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $item->status_pembayaran }}">
                            {{ ucfirst($item->status_pembayaran) }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_donasi)->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data donasi dalam rentang tanggal ini.</td>
                </tr>
            @endforelse
        </tbody>

        @if ($donasi->count() > 0)
            <tfoot>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="4" style="text-align: right;">
                        <strong>Total Donasi: Rp {{ number_format($totalDonasi, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </tfoot>
        @endif
    </table>


</body>

</html>
