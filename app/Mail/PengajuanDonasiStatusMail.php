<?php

namespace App\Mail;

use App\Models\PengajuanDonasi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengajuanDonasiStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;

    public function __construct(PengajuanDonasi $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    public function build()
    {
        return $this->subject('Status Pengajuan Donasi Anda: ' . ucfirst($this->pengajuan->status_pengajuan))
            ->view('email.pengajuan-status')
            ->with([
                'pengajuan' => $this->pengajuan,
            ]);
    }
}
