<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Event</title>
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

        p {
            margin: 0;
        }
    </style>
</head>

<body>
    <h2>Laporan Peminjaman Barang</h2>
    <p>Periode: {{ $tanggal_mulai }} s/d {{ $tanggal_selesai }}</p>

    <table>
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
                    <td>Rp {{ number_format($item->target_donasi, 0, ',', '.') ?? '-' }} </td>
                    <td>{{ $item->pengajuan->judul_pengajuan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data event dalam rentang tanggal ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
