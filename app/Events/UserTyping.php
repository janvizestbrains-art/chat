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

class UserTyping implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public int $conversation_id,

        public int $receiver_id,
        public bool $istyping,

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

            new PrivateChannel('users.'.$this->receiver_id),

        ];
    }
    public function broadcastAs():string
    {
            return "user.typing";
    }
    public function broadcastWith():array
    {
        return[
            "conversation_id" =>$this->conversation_id,

            "receiver_id" =>$this->receiver_id,
            "istyping" =>$this->istyping,
        ];
    }
}
