<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalDocument extends Model
{
    protected $table = 'rental_documents';

    protected $fillable = [
        'rental_id',
        'process',
        'image',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}