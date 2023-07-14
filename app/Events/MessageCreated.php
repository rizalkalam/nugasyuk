<?php

namespace App\Events;

use Illuminate\Bus\Queueable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, InteractsWithQueue, Queueable, SerializesModels;

    public $pesan;

    /**
     * Create a new event instance.
     */
    public function __construct($pesan)
    {
        $this->pesan = $pesan;
        $this->dontBroadcastToCurrentUser();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('pesan.' . $this->pesan->percakapan_id),
        ];
    }

    public function broadcastAs()
    {
        return new PrivateChannel('pesan.' . $this->pesan->percakapan_id);
    }
}
