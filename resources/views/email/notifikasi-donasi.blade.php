<!DOCTYPE html>
<html>

<head>
    <title>Status Donasi</title>
</head>

<body>
    <h2>Halo {{ $donasi->nama_donatur }},</h2>

    <p>Terima kasih telah berdonasi sebesar <strong>Rp{{ number_format($donasi->jumlah_donasi, 0, ',', '.') }}</strong>.
    </p>

    <p>Status donasi Anda saat ini adalah:
        @if ($donasi->status_pembayaran === 'berhasil')
            <span style="color:green"><strong>BERHASIL</strong></span>
        @elseif($donasi->status_pembayaran === 'pending')
            <span style="color:orange"><strong>MENUNGGU PEMBAYARAN</strong></span>
        @elseif($donasi->status_pembayaran === 'gagal')
            <span style="color:red"><strong>GAGAL</strong></span>
        @endif
    </p>

    <p>Order ID: <strong>{{ $donasi->kode_transaksi_gateway }}</strong></p>

    @if ($donasi->status_pembayaran === 'berhasil')
        <p>Donasi Anda sudah kami terima. Terima kasih atas dukungan Anda.</p>
    @elseif($donasi->status_pembayaran === 'pending')
        <p>Silakan selesaikan pembayaran untuk memproses donasi Anda.</p>
    @elseif($donasi->status_pembayaran === 'gagal')
        <p>Donasi Anda tidak berhasil diproses. Anda dapat mencoba kembali.</p>
    @endif

    <br>
    <p>Salam hangat,</p>
    <p>Tim Donasi</p>
</body>

</html>
