<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DamageClaim extends Model
{
    protected $table = 'damage_claims';

    protected $fillable = [
        'rental_id',
        'damage_type',
        'damage_part',
        'description',
        'repair_fee',
        'status',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}