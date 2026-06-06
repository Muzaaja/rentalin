<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    protected $table = 'toko';

    protected $fillable = [
        'user_id',
        // Step 1
        'nama_toko',
        'alamat_toko',
        'deskripsi',
        'no_telepon',
        'foto_toko',
        // Step 2 identitas
        'nik',
        'nama_lengkap_ktp',
        'foto_ktp',
        'foto_selfie',
        // Step 2 rekening
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik_rekening',
        // Status
        'status',
    ];

    /**
     * Relasi ke User pemilik toko
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}