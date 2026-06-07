<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public static function send(
    $userId,
    $title,
    $message,
    $type,
    $status = null,
    $url = null,
    $rentalId = null,
    $paymentId = null
){

    logger("NOTIFICATION MASUK");

    $icon = match($type) {

    'request' => 'request.png',

    'payment' => 'payment.png',

    'extend' => 'extend.png',

    'return' => 'return.png',

    'damage' => 'damage.png',

    'finish' => 'finish.png',

    'cancel' => 'cancel.png',

    default => 'default.png'

};

    Notification::create([

        'user_id'=>$userId,

        'rental_id'=>$rentalId,

        'payment_id'=>$paymentId,

        'title'=>$title,

        'message'=>$message,

        'type'=>$type,

        'icon' => $icon,

        'status'=>$status,

        'url'=>$url,

        'is_read'=>false

    ]);

    }
}