<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
    protected $fillable = [
        'user_id',
        'photo_ktp',
        'selfie',
        'nik',
        'status',
        'notes',
        'verified_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}