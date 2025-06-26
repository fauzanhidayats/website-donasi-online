<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Donatur\DonasiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// Webhook dari Midtrans (status pembayaran)
Route::post('/donasi/webhook-midtrans', [DonasiController::class, 'webhook']);
