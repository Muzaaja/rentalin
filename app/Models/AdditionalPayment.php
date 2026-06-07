<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalPayment extends Model
{
    protected $fillable = [
        'rental_id',
        'damage_claim_id',
        'amount',
        'payment_method',
        'payment_status',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function damageClaim()
    {
        return $this->belongsTo(DamageClaim::class);
    }
}