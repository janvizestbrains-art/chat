<?php

namespace App\Events;

use App\Models\Conversation;
use Carbon\Carbon;
use Dom\Text;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public int $conversation_id,
        public int $message_id,
        public int $user_id,
        public int $actor_id,
        public string $actor_name,
        public string $message,
        public string $type,
        public string $content,
        public bool $is_read,
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
    public function broadcastWith():array
    {
        return [
            "conversation_id" =>$this->conversation_id,
            "message_id" =>$this->message_id,
            "user_id"=>$this->user_id,
            "actor_id"=>$this->actor_id,
            "actor_name"=>$this->actor_name,
            "message" =>$this->message,
            "type"=>$this->type,
            "content" =>$this->content,
            "is_read" =>$this->is_read,
            "updated_at" =>$this->updated_at,
        ];
    }
    public function broadcastAs():string
    {
            return "activity.created";
    }
}
