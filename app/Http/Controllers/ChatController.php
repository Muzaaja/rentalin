<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Rental;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $filter = $request->query('filter', 'semua');

        $query = Rental::with(['owner', 'tenant', 'item'])
            ->where(function ($q) use ($userId) {
                $q->where('owner_id', $userId)
                  ->orWhere('tenant_id', $userId);
            });

        if ($filter === 'penyewa') {
            $query->where('tenant_id', $userId);
        }

        if ($filter === 'pemilik') {
            $query->where('owner_id', $userId);
        }

        $rentals = $query
            ->withMax('chats', 'created_at')
            ->orderByDesc('chats_max_created_at')
            ->orderByDesc('created_at')
            ->get();

        $hasStore = Toko::where('user_id', $userId)->exists();

        return view('pages.chat.index', compact('rentals', 'filter', 'hasStore'));
    }

    public function show(Request $request, $rentalId)
    {
        $userId = Auth::id();
        $filter = $request->query('filter', 'semua');

        $rental = Rental::with(['owner', 'tenant', 'item', 'chats.sender'])
            ->where(function ($q) use ($userId) {
                $q->where('owner_id', $userId)
                  ->orWhere('tenant_id', $userId);
            })
            ->findOrFail($rentalId);

        $query = Rental::with(['owner', 'tenant', 'item'])
            ->where(function ($q) use ($userId) {
                $q->where('owner_id', $userId)
                  ->orWhere('tenant_id', $userId);
            });

        if ($filter === 'penyewa') {
            $query->where('tenant_id', $userId);
        }

        if ($filter === 'pemilik') {
            $query->where('owner_id', $userId);
        }

        $rentals = $query
            ->withMax('chats', 'created_at')
            ->orderByDesc('chats_max_created_at')
            ->orderByDesc('created_at')
            ->get();

        $hasStore = Toko::where('user_id', $userId)->exists();

        return view('pages.chat.show', compact('rental', 'rentals', 'filter', 'hasStore'));
    }

    public function send(Request $request, $rentalId)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $userId = Auth::id();

        $rental = Rental::where(function ($q) use ($userId) {
                $q->where('owner_id', $userId)
                  ->orWhere('tenant_id', $userId);
            })
            ->findOrFail($rentalId);

        $receiverId = (int) $userId === (int) $rental->owner_id
            ? $rental->tenant_id
            : $rental->owner_id;

        $chat = Chat::create([
            'rental_id' => $rental->id,
            'sender_id' => $userId,
            'receiver_id' => $receiverId,
            'message' => $request->message,
            'is_read' => false,
        ]);

        broadcast(new MessageSent($chat))->toOthers();

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $chat->id,
                'rental_id' => $chat->rental_id,
                'sender_id' => $chat->sender_id,
                'receiver_id' => $chat->receiver_id,
                'message' => $chat->message,
                'created_at' => $chat->created_at->format('H:i'),
            ],
        ]);
    }

    public function startFromRental($rentalId)
    {
        $userId = Auth::id();

        $rental = Rental::where(function ($q) use ($userId) {
                $q->where('owner_id', $userId)
                  ->orWhere('tenant_id', $userId);
            })
            ->findOrFail($rentalId);

        return redirect()->route('chat.show', $rental->id);
    }
}