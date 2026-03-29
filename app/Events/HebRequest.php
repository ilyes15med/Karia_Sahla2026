<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; 

class HebRequest implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $hote_name;
    public $date_create;
    public $nom_Heb;

    public function __construct($message,$hote_name,$date_create,$nom_Heb)
    {
        $this->message = $message;
        $this->hote_name=$hote_name;
        $this->date_create=$date_create;
        $this->nom_Heb=$nom_Heb;
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('reqHeb')];
    }

    public function broadcastAs(): string
    {
        return 'HebRequest';
    }
}
