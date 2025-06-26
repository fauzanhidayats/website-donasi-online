<?php

namespace App\Mail;

use App\Models\Donasi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonasiStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $donasi;

    /**
     * Create a new message instance.
     */
    public function __construct(Donasi $donasi)
    {
        $this->donasi = $donasi;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Status Donasi Anda: ' . ucfirst($this->donasi->status_pembayaran))
            ->view('email.notifikasi-donasi')
            ->with([
                'donasi' => $this->donasi,
            ]);
    }
}
