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

class ActivityUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public int $activity_id,
        public int $conversation_id,
        public int $message_id,
        public string $type,
        public bool $is_read,
        public int $actor_id,
        public string $actor_name,
        public int $user_id,
        public string $content,
        public string $message,
        public Carbon $updated_at,


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
            new PrivateChannel('users.'.$this->user_id),
        ];
    }
    public function broadcastWith(): array
    {
        return
        [
            "activity_id" =>$this->activity_id,
            "conversation_id" =>$this->conversation_id,
            "message_id" =>$this->message_id,
            "type" =>$this->type,
            "is_read" =>$this->is_read,
            "actor_id" =>$this->actor_id,
            "actor_name" =>$this->actor_name,
            "user_id" =>$this->user_id,
            "content" =>$this->content,
            "message" =>$this->message,
            "updated_at" =>$this->updated_at,
        ];
    }
    public function broadcastAs():string
    {

        return "activity.updated";
    }
}
