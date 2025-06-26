<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Tambahkan URL webhook Midtrans Anda di sini
        'api/donasi/webhook-midtrans', // PASTIKAN SESUAI DENGAN ROUTE ANDA
        // Jika ada route API lain yang tidak memerlukan CSRF, tambahkan juga di sini
    ];
}
