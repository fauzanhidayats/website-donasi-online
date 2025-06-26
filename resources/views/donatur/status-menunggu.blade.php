<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>status Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="card shadow-sm">
                    <div class="card-body p-5">

                        <h2 class="mb-4">
                            Status Pembayaran:
                            <span
                                class="badge 
                            @if ($status_pembayaran === 'berhasil') bg-success
                            @elseif($status_pembayaran === 'pending') bg-warning text-dark
                            @elseif($status_pembayaran === 'gagal') bg-danger
                            @else bg-secondary @endif
                        ">
                                {{ ucfirst($status_pembayaran) }}
                            </span>
                        </h2>

                        @if ($status_pembayaran === 'pending')
                            <p class="lead">Terima kasih telah melakukan donasi.</p>
                            <p>Silakan selesaikan pembayaran Anda sesuai instruksi yang telah diberikan di halaman
                                pembayaran.</p>

                            <div class="alert alert-info mt-4" role="alert">
                                Kami masih menunggu konfirmasi dari pihak pembayaran. Anda akan mendapatkan notifikasi
                                setelah pembayaran berhasil.
                            </div>
                        @elseif ($status_pembayaran === 'gagal')
                            <p class="lead text-danger fw-bold">Pembayaran Gagal</p>
                            <p>Silakan coba kembali atau gunakan metode pembayaran lain.</p>

                            <div class="alert alert-danger mt-4" role="alert">
                                Pastikan Anda menyelesaikan transaksi sesuai batas waktu yang ditentukan.
                            </div>
                        @elseif ($status_pembayaran === 'tidak_ditemukan')
                            <p class="text-warning">Donasi dengan ID <strong>{{ $order_id }}</strong> tidak
                                ditemukan.
                            </p>

                            <div class="alert alert-warning mt-4" role="alert">
                                Periksa kembali link atau ID transaksi Anda. Jika masalah berlanjut, hubungi tim
                                support.
                            </div>
                        @else
                            <p>Status pembayaran saat ini: <strong>{{ ucfirst($status_pembayaran) }}</strong></p>
                        @endif

                        <a href="{{ url('/') }}" class="btn btn-outline-primary mt-4">
                            <i class="bi bi-house-door-fill me-1"></i> Kembali ke Beranda
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</body>

</html>
