<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donasi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'donasi';
    protected $fillable = [
        'user_id',
        'event_id',
        'pengajuan_id',
        'jumlah_donasi',
        'tanggal_donasi',
        'status_pembayaran',
        'nama_donatur',
        'email_donatur',
        'no_hp_donatur',
        'metode_pembayaran',
        'kode_transaksi_gateway'
    ];
    public $timestamps = false;

    protected $casts = ['tanggal_donasi' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanDonasi::class, 'pengajuan_id');
    }
}
