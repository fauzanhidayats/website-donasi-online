<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Form Donasi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Midtrans Snap Sandbox -->
    <!-- Pastikan data-client-key berisi client key SANDBOX Anda -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
            /* Menggunakan font Inter */
        }

        .donasi-container {
            max-width: 600px;
            margin: 60px auto;
            padding: 30px;
            /* Padding lebih besar */
            background-color: white;
            border-radius: 15px;
            /* Sudut lebih membulat */
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            /* Bayangan lebih dalam */
        }

        .event-image {
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
            /* Sudut gambar lebih membulat */
            width: 100%;
            /* Pastikan gambar mengisi lebar container */
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        /* Gaya untuk pesan kustom (pengganti alert) */
        .custom-message-box {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 1050;
            display: none;
            /* Sembunyikan secara default */
            text-align: center;
            max-width: 350px;
            width: 90%;
        }

        .custom-message-box .message-content {
            margin-bottom: 20px;
        }

        .custom-message-box .message-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .custom-message-box-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
            /* Sembunyikan secara default */
        }
    </style>
</head>

<body>

    <div class="container donasi-container">
        <h4 class="mb-4 text-center">Form Donasi</h4>

        @if (isset($event))
            <div class="mb-3 p-3 bg-light border rounded">
                <h5 class="mb-1">{{ $event->nama_event }}</h5>
                <p class="mb-0 text-muted">Target: Rp {{ number_format($event->target_donasi, 0, ',', '.') }}</p>
                @if ($event->foto_event)
                    <img src="{{ asset('storage/' . $event->foto_event) }}" alt="Event"
                        class="img-fluid mt-2 event-image" />
                @endif
            </div>
        @else
            <div class="alert alert-warning">Event tidak ditemukan atau tidak valid.</div>
        @endif

        <form id="donasi-form" novalidate class="needs-validation"> {{-- Tambahkan class needs-validation --}}
            @csrf
            <input type="hidden" name="event_id" value="{{ $event_id ?? '' }}">
            <input type="hidden" name="pengajuan_id" value="{{ $pengajuan_id ?? '' }}">

            <div class="mb-3">
                <label for="nama_donatur" class="form-label">Nama Donatur (Opsional)</label>
                <input type="text" id="nama_donatur" name="nama_donatur" class="form-control rounded"
                    placeholder="Contoh: Budi Santoso" maxlength="100">
            </div>

            <div class="mb-3">
                <label for="email_donatur" class="form-label">Email (Opsional)</label>
                <input type="email" id="email_donatur" name="email_donatur" class="form-control rounded"
                    placeholder="Contoh: email@anda.com" maxlength="100">
            </div>

            <div class="mb-3">
                <label for="no_hp_donatur" class="form-label">Nomor HP (Opsional)</label>
                <input type="tel" id="no_hp_donatur" name="no_hp_donatur" class="form-control rounded"
                    placeholder="Contoh: 08123456789" maxlength="20">
            </div>

            <div class="mb-3">
                <label for="jumlah_donasi" class="form-label">Jumlah Donasi (Rp) <span
                        class="text-danger">*</span></label>
                <input type="number" id="jumlah_donasi" name="jumlah_donasi" class="form-control rounded"
                    min="1000" required placeholder="Minimal Rp 1.000">
                <div class="invalid-feedback">Jumlah donasi minimal Rp 1.000</div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-success fw-semibold rounded-pill py-2" id="pay-button">Bayar
                    Sekarang</button>
            </div>
        </form>
    </div>

    <!-- Custom Message Box (Pengganti alert) -->
    <div class="custom-message-box-overlay" id="messageOverlay"></div>
    <div class="custom-message-box" id="messageBox">
        <p class="message-content" id="messageContent"></p>
        <button class="message-button rounded" id="messageButton">OK</button>
    </div>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script>
        // Fungsi untuk menampilkan pesan kustom (pengganti alert)
        function showCustomMessage(message, callback) {
            $('#messageContent').text(message);
            $('#messageBox, #messageOverlay').fadeIn(200);
            $('#messageButton').off('click').on('click', function() {
                $('#messageBox, #messageOverlay').fadeOut(200);
                if (typeof callback === 'function') {
                    callback();
                }
            });
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#donasi-form').on('submit', function(e) {
                e.preventDefault();

                // Bootstrap form validation
                if (!this.checkValidity()) {
                    e.stopPropagation();
                    $(this).addClass('was-validated'); // Menampilkan feedback validasi Bootstrap
                    return;
                } else {
                    $(this).removeClass('was-validated'); // Hapus jika sudah valid
                }

                let formData = new FormData(this);
                let $btn = $('#pay-button');
                let $inputs = $(this).find('input, button'); // Pilih semua input dan button

                // Disable semua input dan tombol saat request diproses
                $inputs.prop('disabled', true);
                $btn.text('Memproses...');

                $.ajax({
                    url: "/donasi/pay",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (!res.snap_token) {
                            showCustomMessage(
                                'Gagal mendapatkan token pembayaran. Silakan coba lagi.',
                                function() {
                                    $inputs.prop('disabled',
                                        false); // Aktifkan kembali input
                                    $btn.text('Bayar Sekarang');
                                });
                            return;
                        }

                        // Panggil Snap Pop-up
                        window.snap.pay(res.snap_token, {
                            onSuccess: function(result) {
                                // Logika redirect berdasarkan transaction_status
                                if (result.transaction_status == 'capture' || result
                                    .transaction_status == 'settlement') {
                                    showCustomMessage(
                                        "Pembayaran berhasil! Mengarahkan Anda...",
                                        function() {
                                            window.location.href =
                                                "/donasi/sukses?order_id=" +
                                                result.order_id;
                                        });
                                } else if (result.transaction_status == 'pending') {
                                    showCustomMessage(
                                        "Pembayaran Anda sedang menunggu konfirmasi. Mengarahkan Anda...",
                                        function() {
                                            window.location.href =
                                                "/donasi/menunggu?order_id=" +
                                                result.order_id;
                                        });
                                } else {
                                    // Untuk status lain (deny, expire, cancel, refund, partial_refund)
                                    // Semua status ini akan dianggap 'gagal' di backend.
                                    let message =
                                        "Pembayaran Anda gagal atau dibatalkan. Mengarahkan Anda...";
                                    // Anda bisa menambahkan kondisi spesifik untuk pesan jika diperlukan,
                                    // misal: if (result.transaction_status === 'expire') message = "Pembayaran Anda kadaluarsa...";
                                    showCustomMessage(message, function() {
                                        window.location.href =
                                            "/donasi/menunggu?order_id=" +
                                            result.order_id + "&status=" +
                                            result
                                            .transaction_status; // Tetap kirim status detail ke URL
                                    });
                                }
                                $inputs.prop('disabled',
                                    false
                                    ); // Aktifkan kembali input setelah redirect
                                $btn.text('Bayar Sekarang');
                            },
                            onPending: function(result) {
                                showCustomMessage(
                                    "Pembayaran Anda sedang menunggu konfirmasi. Mengarahkan Anda...",
                                    function() {
                                        window.location.href =
                                            "/donasi/menunggu?order_id=" +
                                            result.order_id;
                                    });
                                $inputs.prop('disabled', false);
                                $btn.text('Bayar Sekarang');
                            },
                            onError: function(result) {
                                showCustomMessage(
                                    "Pembayaran gagal. Silakan coba lagi. Mengarahkan Anda...",
                                    function() {
                                        window.location.href =
                                            "/donasi/menunggu?order_id=" +
                                            result.order_id + "&status=error";
                                    });
                                $inputs.prop('disabled', false);
                                $btn.text('Bayar Sekarang');
                            },
                            onClose: function() {
                                showCustomMessage(
                                    "Anda menutup jendela pembayaran tanpa menyelesaikannya. Silakan coba lagi.",
                                    function() {
                                        // Aktifkan kembali form dan tombol jika user menutup pop-up
                                        $inputs.prop('disabled', false);
                                        $btn.text('Bayar Sekarang');
                                    });
                            }
                        });
                    },
                    error: function(xhr) {
                        let msg = xhr.responseJSON?.message ||
                            'Terjadi kesalahan saat memproses pembayaran.';
                        showCustomMessage(msg, function() {
                            $inputs.prop('disabled', false); // Aktifkan kembali input
                            $btn.text('Bayar Sekarang');
                        });
                        console.error("DEBUG AJAX Error:", xhr.responseText);
                    }
                });
            });
        });
    </script>

</body>

</html>
