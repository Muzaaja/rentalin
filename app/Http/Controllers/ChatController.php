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

        $hasStore = Toko::where('user_id', $userId)->exists();

        // Kalau user belum punya toko, dia dianggap penyewa saja dan tidak perlu tab.
        $filter = $hasStore
            ? $request->query('filter', 'semua')
            : 'penyewa';

        // Biar aman kalau ada query filter aneh.
        if (!in_array($filter, ['semua', 'penyewa', 'pemilik'])) {
            $filter = $hasStore ? 'semua' : 'penyewa';
        }

        // Kalau tidak punya toko tapi memaksa buka ?filter=pemilik, tetap balik ke penyewa.
        if (!$hasStore && $filter === 'pemilik') {
            $filter = 'penyewa';
        }

        $query = Rental::with([
                'owner',
                'tenant',
                'item',
                'chats' => function ($q) {
                    $q->latest();
                },
            ])
            ->where(function ($q) use ($userId) {
                $q->where('owner_id', $userId)
                  ->orWhere('tenant_id', $userId);
            });

        if (!$hasStore) {
            $query->where('tenant_id', $userId);
        }

        if ($hasStore && $filter === 'penyewa') {
            $query->where('tenant_id', $userId);
        }

        if ($hasStore && $filter === 'pemilik') {
            $query->where('owner_id', $userId);
        }

        $rentals = $query
            ->withMax('chats', 'created_at')
            ->orderByDesc('chats_max_created_at')
            ->orderByDesc('created_at')
            ->get();

        return view('pages.chat.index', compact('rentals', 'filter', 'hasStore'));
    }

    public function show(Request $request, $rentalId)
    {
        $userId = Auth::id();

        $hasStore = Toko::where('user_id', $userId)->exists();

        $filter = $hasStore
            ? $request->query('filter', 'semua')
            : 'penyewa';

        if (!in_array($filter, ['semua', 'penyewa', 'pemilik'])) {
            $filter = $hasStore ? 'semua' : 'penyewa';
        }

        if (!$hasStore && $filter === 'pemilik') {
            $filter = 'penyewa';
        }

        $rental = Rental::with([
                'owner',
                'tenant',
                'item',
                'chats' => function ($q) {
                    $q->with('sender')->oldest();
                },
            ])
            ->where(function ($q) use ($userId) {
                $q->where('owner_id', $userId)
                  ->orWhere('tenant_id', $userId);
            })
            ->findOrFail($rentalId);

        $query = Rental::with([
                'owner',
                'tenant',
                'item',
                'chats' => function ($q) {
                    $q->latest();
                },
            ])
            ->where(function ($q) use ($userId) {
                $q->where('owner_id', $userId)
                  ->orWhere('tenant_id', $userId);
            });

        if (!$hasStore) {
            $query->where('tenant_id', $userId);
        }

        if ($hasStore && $filter === 'penyewa') {
            $query->where('tenant_id', $userId);
        }

        if ($hasStore && $filter === 'pemilik') {
            $query->where('owner_id', $userId);
        }

        $rentals = $query
            ->withMax('chats', 'created_at')
            ->orderByDesc('chats_max_created_at')
            ->orderByDesc('created_at')
            ->get();

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