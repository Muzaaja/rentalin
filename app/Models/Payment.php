<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [

        'rental_id',

        'order_id',

        'snap_token',

        'transaction_id',

        'payment_method',

        'amount',

        'payment_status',

        'status',

        'expired_at',

    ];

    protected $casts = [

        'expired_at' => 'datetime',

        'amount' => 'integer',

    ];

    public function rental()
    {
        return $this->belongsTo(
            Rental::class
        );
    }
}