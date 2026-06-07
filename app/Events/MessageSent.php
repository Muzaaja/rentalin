<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public Chat $chat;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat->load('sender');
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('rental-chat.' . $this->chat->rental_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->chat->id,
            'rental_id' => $this->chat->rental_id,
            'sender_id' => $this->chat->sender_id,
            'receiver_id' => $this->chat->receiver_id,
            'sender_name' => $this->chat->sender->name ?? 'User',
            'message' => $this->chat->message,
            'created_at' => $this->chat->created_at->format('H:i'),
        ];
    }
}