<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageUpdate implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */



    public function __construct(
        public int $message_id,
        public int $conversation_id,
        public int $receiver_id,
        public int $sender_id,
        public string $message,
        public Carbon $updated_at,
        public bool $is_edited,
    ) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
      public function broadcastOn(): array
    {
        return [
            new PrivateChannel('users.' . $this->receiver_id),
            new PrivateChannel('users.' . $this->sender_id),
        ];
    }
       public function broadcastAs(): string
    {
        return 'message.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'message_id' => $this->message_id,
            'conversation_id' => $this->conversation_id,
            'receiver_id' => $this->receiver_id,
            'sender_id' => $this->sender_id,
            'message' => $this->message,
            'updated_at' => $this->updated_at->toISOString(),
            'is_edited' => $this->is_edited,
        ];
    }
}
