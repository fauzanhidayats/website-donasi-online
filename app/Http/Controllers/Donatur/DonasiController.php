<?php

namespace App\Http\Controllers\Donatur;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Event;
use App\Models\Donasi;
use Midtrans\Notification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\DonasiStatusMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class DonasiController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function create(Request $request)
    {
        $event_id = $request->query('event_id');
        $pengajuan_id = $request->query('pengajuan_id');
        $event = null;

        if ($event_id) {
            $event = Event::find($event_id);
            if (!$event) {
                abort(404, 'Event tidak ditemukan');
            }
            $pengajuan_id = $pengajuan_id ?? $event->pengajuan_id;
        }

        return view('donatur.donasi', compact('event_id', 'pengajuan_id', 'event'));
    }

    public function pay(Request $request)
    {
        Log::info('Request donasi (pay):', $request->all());

        $validated = $request->validate([
            'jumlah_donasi' => 'required|numeric|min:1000',
            'nama_donatur' => 'nullable|string|max:100',
            'email_donatur' => 'nullable|email|max:100',
            'no_hp_donatur' => 'nullable|string|max:20',
            'event_id' => 'nullable|exists:events,id',
            'pengajuan_id' => 'nullable|exists:pengajuan_donasi,id',
            'metode_pembayaran' => 'nullable|string|max:50',  // Tambahan validasi
        ]);

        try {
            DB::beginTransaction();

            if (!empty($validated['event_id'])) {
                $event = Event::findOrFail($validated['event_id']);
                $validated['pengajuan_id'] = $validated['pengajuan_id'] ?? $event->pengajuan_id;
            }

            $order_id = 'DON-' . time() . '-' . strtoupper(Str::random(6));

            $donasi = Donasi::create([
                'user_id' => auth()->check() ? auth()->id() : null,
                'event_id' => $validated['event_id'] ?? null,
                'pengajuan_id' => $validated['pengajuan_id'] ?? null,
                'jumlah_donasi' => $validated['jumlah_donasi'],
                'nama_donatur' => $validated['nama_donatur'] ?? 'Anonim',
                'email_donatur' => $validated['email_donatur'] ?? 'anonim@donasi.com',
                'no_hp_donatur' => $validated['no_hp_donatur'] ?? '000000000000',
                'metode_pembayaran' => $validated['metode_pembayaran'] ?? null,  // Simpan metode pembayaran
                'status_pembayaran' => 'pending',
                'tanggal_donasi' => now(),
                'kode_transaksi_gateway' => $order_id,
            ]);

            $params = [
                'transaction_details' => [
                    'order_id' => $order_id,
                    'gross_amount' => (int)$donasi->jumlah_donasi,
                ],
                'customer_details' => [
                    'first_name' => $donasi->nama_donatur,
                    'email' => $donasi->email_donatur,
                    'phone' => $donasi->no_hp_donatur,
                ],
                'enabled_payments' => ['credit_card', 'bank_transfer', 'gopay', 'shopeepay', 'akulaku'],
                'vtweb' => []
            ];

            Log::info('Parameter yang dikirim ke Midtrans (pay):', $params);

            $snapResponse = Snap::createTransaction($params);
            $snapToken = $snapResponse->token;

            DB::commit();

            return response()->json(['snap_token' => $snapToken, 'donasi_id' => $donasi->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat membuat donasi atau transaksi Midtrans:', ['msg' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Gagal memproses pembayaran: ' . $e->getMessage()], 500);
        }
    }



    public function webhook(Request $request)
    {
        Log::info('Midtrans Webhook Received (no paid_at):', $request->all());

        try {
            DB::beginTransaction();

            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $orderId = $notification->order_id;
            $grossAmount = $notification->gross_amount;
            $statusCode = $notification->status_code;
            $paymentType = $notification->payment_type ?? null;  // Ambil metode pembayaran dari webhook

            Log::info('Notification Details:', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
                'gross_amount' => $grossAmount,
                'status_code' => $statusCode,
                'payment_type' => $paymentType,
            ]);

            $donasi = Donasi::where('kode_transaksi_gateway', $orderId)->first();

            if (!$donasi) {
                Log::warning("Donasi dengan kode_transaksi_gateway {$orderId} tidak ditemukan di database.");
                DB::rollBack();
                return response('Order ID not found', 404);
            }

            if ((int)$donasi->jumlah_donasi !== (int)$grossAmount) {
                Log::warning("Jumlah donasi tidak cocok untuk order ID: {$orderId}. Expected: {$donasi->jumlah_donasi}, Received: {$grossAmount}");
                DB::rollBack();
                return response('Amount mismatch', 400);
            }

            // Update metode pembayaran jika ada info dari webhook
            if ($paymentType) {
                $donasi->metode_pembayaran = $paymentType;
            }

            switch ($transactionStatus) {
                case 'capture':
                    if ($fraudStatus == 'accept') {
                        $donasi->status_pembayaran = 'berhasil';
                    } else if ($fraudStatus == 'challenge') {
                        $donasi->status_pembayaran = 'pending';
                    } else {
                        $donasi->status_pembayaran = 'gagal';
                    }
                    break;
                case 'settlement':
                    $donasi->status_pembayaran = 'berhasil';
                    break;
                case 'pending':
                    $donasi->status_pembayaran = 'pending';
                    break;
                case 'deny':
                case 'expire':
                case 'cancel':
                case 'refund':
                case 'partial_refund':
                    $donasi->status_pembayaran = 'gagal';
                    break;
                default:
                    $donasi->status_pembayaran = 'pending';
                    break;
            }

            $donasi->save();

            // Kirim email notifikasi status donasi
            if (filter_var($donasi->email_donatur, FILTER_VALIDATE_EMAIL)) {
                Mail::to($donasi->email_donatur)->send(new DonasiStatusMail($donasi));
            }

            DB::commit();

            Log::info("Donasi dengan order_id={$orderId} berhasil diupdate ke status: {$donasi->status_pembayaran}");
            return response('OK', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat memproses Midtrans Webhook:', ['msg' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response('Internal Server Error', 500);
        }
    }


    public function menunggu(Request $request)
    {
        $orderId = $request->query('order_id');
        $donasi = Donasi::where('kode_transaksi_gateway', $orderId)->first();

        $status_from_query = $request->query('status');

        if (!$donasi) {
            return view('donatur.status-menunggu')->with([
                'status_pembayaran' => 'tidak_ditemukan',
                'order_id' => $orderId,
                'pesan' => 'Maaf, data donasi tidak ditemukan.',
                'status_snap_callback' => $status_from_query
            ]);
        }

        $current_status = $donasi->status_pembayaran;
        $message = "Donasi Anda dengan Order ID: {$orderId} sedang menunggu pembayaran atau dalam proses verifikasi.";

        if ($current_status === 'berhasil') {
            return redirect()->route('donasi.sukses', ['order_id' => $orderId]);
        } elseif ($current_status === 'gagal') { // Hanya cek 'gagal' karena enum Anda hanya 3
            $message = "Mohon maaf, donasi Anda dengan Order ID: {$orderId} berstatus Gagal. Silakan coba lagi.";
        }

        return view('donatur.status-menunggu')->with([
            'donasi' => $donasi,
            'order_id' => $orderId,
            'status_pembayaran' => $current_status,
            'pesan' => $message,
            'status_snap_callback' => $status_from_query
        ]);
    }

    public function sukses(Request $request)
    {
        $orderId = $request->query('order_id');
        $donasi = Donasi::where('kode_transaksi_gateway', $orderId)->first();

        if (!$donasi || $donasi->status_pembayaran !== 'berhasil') {
            return redirect()->route('donasi.menunggu', ['order_id' => $orderId]);
        }

        return view('donatur.status-sukses')->with([
            'donasi' => $donasi,
            'order_id' => $orderId,
        ]);
    }
}
