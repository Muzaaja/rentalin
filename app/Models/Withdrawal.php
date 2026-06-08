<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'user_id',
        'jumlah',
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik',
        'ref_code',
        'status',
        'catatan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}