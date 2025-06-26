<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajuanDonasi extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_donasi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'no_telp',
        'alamat',
        'judul_pengajuan',
        'deskripsi',
        'bukti',
        'target_pengajuan',
        'status_pengajuan',
        'tanggal_pengajuan'
    ];

    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'pengajuan_id');
    }

    public function donasi()
    {
        return $this->hasMany(Donasi::class, 'pengajuan_id');
    }
}
