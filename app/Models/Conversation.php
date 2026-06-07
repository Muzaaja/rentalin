<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'transaction_id',
        'product_id',
        'owner_id',
        'tenant_id',
        'last_message',
        'last_message_at',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }
}