<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    protected $fillable = ['user_one_id', 'user_two_id', 'last_message_at'];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function userOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public static function getOrCreateChatBetweenUsers($userOneId, $userTwoId)
    {
        $chat = self::where(function ($query) use ($userOneId, $userTwoId) {
            $query->where('user_one_id', $userOneId)
                ->where('user_two_id', $userTwoId);
        })->orWhere(function ($query) use ($userOneId, $userTwoId) {
            $query->where('user_one_id', $userTwoId)
                ->where('user_two_id', $userOneId);
        })->first();

        if (!$chat) {
            $chat = self::create([
                'user_one_id' => $userOneId,
                'user_two_id' => $userTwoId,
                'last_message_at' => now(),
            ]);
        }

        return $chat;
    }

    public function getOtherUser()
    {
        return auth()->id() === $this->user_one_id ? $this->userTwo : $this->userOne;
    }

    public function lastMessage()
    {
        return $this->messages()->latest()->first();
    }

    public function getLastMessageAtAttribute()
    {
        $lastMessageAt = Carbon::parse($this->attributes['last_message_at']);
        if($lastMessageAt->isToday()) {
            return $lastMessageAt->format('g:i A');
        } elseif ($lastMessageAt->isYesterday()) {
            return 'Yesterday';
        } else {
            return $lastMessageAt->format('M d');
        }
    }

    public function isChatContainsUser($userId)
    {
        return $this->user_one_id === $userId || $this->user_two_id === $userId;
    }

    public function unreadedMessages()
    {
        return $this->messages()->where('sender_id', '!=', auth()->id())->where('is_read', false);
    }

    public function markMessagesAsRead()
    {
        $this->unreadedMessages()
            ->update(['is_read' => true]);
    }

    public function loadMessages($limit = 10)
    {
        return $this->messages()->latest()->take($limit)->get()->reverse();
    }
}
