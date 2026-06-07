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

    Notification::create([

        'user_id'=>$userId,

        'rental_id'=>$rentalId,

        'payment_id'=>$paymentId,

        'title'=>$title,

        'message'=>$message,

        'type'=>$type,

        'status'=>$status,

        'url'=>$url,

        'is_read'=>false

    ]);

    }
}