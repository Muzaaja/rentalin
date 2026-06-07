<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        return Notification::where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->limit(10)
        ->get();
    }

    public function unread()
    {
        return response()->json([
            'count'=>Notification::where(
                'user_id',
                auth()->id()
            )
            ->where('is_read',false)
            ->count()
        ]);
    }

    public function readAll()
    {
        Notification::where(
            'user_id',
            auth()->id()
        )
        ->update([
            'is_read'=>true
        ]);

        return response()->json([
            'success'=>true
        ]);
    }
}