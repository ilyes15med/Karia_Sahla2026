<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = ['chat_id', 'sender_id', 'content', 'is_read'];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function isSender()
    {
        return $this->sender_id == auth()->id();
    }

    public function getCreatedAtAttribute()
    {
        $lastMessageAt = Carbon::parse($this->attributes['created_at']);
        if($lastMessageAt->isToday()) {
            return $lastMessageAt->format('g:i A');
        } elseif ($lastMessageAt->isYesterday()) {
            return 'Yesterday';
        } else {
            return $lastMessageAt->format('M d');
        }
    }
}
