<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_event',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'target_donasi',
        'pengajuan_id',
        'foto_event'
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanDonasi::class, 'pengajuan_id');
    }

    public function donasi()
    {
        return $this->hasMany(Donasi::class, 'event_id');
    }
}
