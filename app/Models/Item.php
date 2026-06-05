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
        'price_per_day',
        'stock',
        'image',
        'status',
        'kelengkapan',
    ];

    protected $casts = [
    'kelengkapan' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
