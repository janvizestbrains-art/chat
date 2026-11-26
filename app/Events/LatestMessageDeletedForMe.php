<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LatestMessageDeletedForMe implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
          public int $conversation_id,
        public int $sender_id,
        public string $latest_message,
    )
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('users.'.$this->sender_id),
        ];
    }
    public function broadcastWith():array
    {
            return[
                "conversation_id" =>$this->conversation_id,
                "sender_id" =>$this->sender_id,
                "latest_message" =>$this->latest_message,
            ];
    }
    public function broadcastAs():string
    {
        return 'latestmessage.deleteforme';
    }
}
