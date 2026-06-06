<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'kelengkapan',
        'price_per_day',
        'stock',
        'image',
        'status',
        'is_cod',
        'is_delivery',
        'late_fee_percentage',
        'has_deposit',
        'deposit_amount',
        'cancellation_policies',
        'kecamatan'
    ];

    protected $casts = [
        'kelengkapan'           => 'array',
        'cancellation_policies' => 'array',
        'image'                 => 'array', // Tambahkan baris ini
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}