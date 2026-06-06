<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rentals';

    protected $fillable = [
        'rental_code',
        'item_id',
        'owner_id',
        'tenant_id',
        'start_date',
        'end_date',
        'delivery_method', // Tambahkan baris ini
        'total_price',
        'status',
        'acceptance_complete',
        'acceptance_note',
        'return_note',
        'damage_description',
        'damage_fee',
        'outgoing_checklist',
        'tenant_return_checklist',
        'accepted_checklist',
        'returned_checklist',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'acceptance_complete' => 'boolean',

        'outgoing_checklist' => 'array',
        'accepted_checklist' => 'array',
        'tenant_return_checklist' => 'array',
        'returned_checklist' => 'array',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function documents()
    {
        return $this->hasMany(RentalDocument::class);
    }

    public function damageClaim()
    {
        return $this->hasOne(DamageClaim::class);
    }
}