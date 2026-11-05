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
use Psy\Readline\Hoa\Console;

class MessageCount implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(

    public int $conversation_id,
    public int $receiver_id,
    public int $count,
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
            new PrivateChannel('users.'.$this->receiver_id)
        ];
    }
    public function broadcastWith():array
    {

        return
        [
            "conversation_id" =>$this->conversation_id,
            "receiver_id" =>$this->receiver_id,
            "count" =>$this->count,
        ];
    }
    public function broadcastAs():string
    {
        return 'message.count';
    }
}
