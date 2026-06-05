<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'rental_id',
        'payment_method',
        'payment_type',
        'installment_plan',
        'installment_paid',
        'installment_due_days',
        'next_due_date',
        'payment_status',
        'amount',
        'status',
    ];

    protected $casts = [
        'next_due_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}