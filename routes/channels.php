<?php

use App\Models\Rental;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('rental-chat.{rentalId}', function ($user, $rentalId) {
    $rental = Rental::find($rentalId);

    if (!$rental) {
        return false;
    }

    return (int) $user->id === (int) $rental->owner_id
        || (int) $user->id === (int) $rental->tenant_id;
});