<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('reqHeb', function ($user) {
    return $user->role==='agent';
});

Broadcast::channel('ReponseAHote', function ($user) {
    return $user->role==='hote';
});

Broadcast::channel('receiveReservation', function ($user) {
    return $user->role==='hote';
});

Broadcast::channel('Rating', function ($user) {
    return $user->role==='hote';
});

Broadcast::channel('chat.{user_id}', function ($user,$user_id) {
    return (int)$user->id===(int) $user_id;
});
