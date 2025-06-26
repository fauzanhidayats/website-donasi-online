<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pengajuan Donasi</title>
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

        .diajukan {
            background-color: #ffc107;
            color: #000;
        }

        .disetujui {
            background-color: #28a745;
        }

        .ditolak {
            background-color: #dc3545;
        }
    </style>
</head>

<body>
    <h2>Laporan Pengajuan Donasi</h2>
    <p>Periode: {{ $tanggal_mulai }} s/d {{ $tanggal_selesai }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No Telp</th>
                <th>Judul Pengajuan</th>
                <th>Target Donasi</th>
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
                        <span class="badge {{ $item->status_pengajuan }}">
                            {{ ucfirst($item->status_pengajuan) }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data pengajuan dalam rentang tanggal ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
