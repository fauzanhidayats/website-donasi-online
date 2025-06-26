<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="mb-4">
                    <h2 class="text-success display-5 fw-bold">🎉 Terima Kasih!</h2>
                    <p class="lead mt-3">Donasi Anda telah berhasil diproses. Kami sangat menghargai kontribusi Anda.
                    </p>
                </div>

                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-success text-white text-start">
                        <h5 class="mb-0">Detail Donasi</h5>
                    </div>
                    <div class="card-body text-start">
                        <p class="mb-2">
                            <strong>Nama Donatur:</strong><br>
                            {{ $donasi->nama_donatur }}
                        </p>
                        <p class="mb-2">
                            <strong>Jumlah Donasi:</strong><br>
                            Rp {{ number_format($donasi->jumlah_donasi, 0, ',', '.') }}
                        </p>
                        <p class="mb-2">
                            <strong>Kode Transaksi:</strong><br>
                            {{ $donasi->kode_transaksi_gateway }}
                        </p>
                        <p class="mb-0">
                            <strong>Status Pembayaran:</strong><br>
                            <span
                                class="badge bg-success text-uppercase">{{ ucfirst($donasi->status_pembayaran) }}</span>
                        </p>
                    </div>
                </div>

                <a href="{{ url('/') }}" class="btn btn-outline-success mt-4">
                    <i class="bi bi-house-door me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</body>

</html>
