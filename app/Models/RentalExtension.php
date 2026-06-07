<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalExtension extends Model
{
    protected $fillable = [
        'rental_id',
        'old_end_date',
        'new_end_date',
        'extra_days',
        'extension_price',
        'payment_type',
        'payment_method',
        'payment_status',
        'installment_plan',
        'installment_paid',
        'installment_due_days',
        'next_due_date',
    ];

    protected $casts = [
        'old_end_date' => 'date',
        'new_end_date' => 'date',
        'next_due_date' => 'date',
        'extension_price' => 'decimal:2',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}