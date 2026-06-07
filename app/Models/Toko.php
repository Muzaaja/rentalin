<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    protected $table = 'toko';

    protected $fillable = [
        'user_id',
        'nama_toko',
        'alamat_toko',
        'deskripsi',
        'no_telepon',
        'foto_toko',
        'nik',
        'nama_lengkap_ktp',
        'foto_ktp',
        'foto_selfie',
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik_rekening',
        'status',
        'notes', 
    ];

    /**
     * Relasi ke User pemilik toko
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}