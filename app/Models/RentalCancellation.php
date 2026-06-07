<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalCancellation extends Model
{
    protected $fillable = [
        'rental_id',
        'cancelled_by',
        'reason',
        'note',
        'refund_amount',
        'refund_status',
    ];

    protected $casts = [
        'refund_amount' => 'decimal:2',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}