<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RentalExtension;
use App\Models\AdditionalPayment;
use App\Models\RentalCancellation;
use App\Models\RentalDocument;

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

    // 1 transaksi bisa punya banyak perpanjangan.
    public function extensions()
    {
        return $this->hasMany(RentalExtension::class);
    }

    // ambil perpanjangan terbaru dari transaksi itu.
    public function latestExtension()
    {
        return $this->hasOne(RentalExtension::class)->latestOfMany();
    }

    // 1 transaksi bisa punya tagihan tambahan.
    public function additionalPayments()
    {
        return $this->hasMany(AdditionalPayment::class);
    }

    // 1 transaksi punya 1 data pembatalan.
    public function cancellation()
    {
        return $this->hasOne(RentalCancellation::class);
    }
}