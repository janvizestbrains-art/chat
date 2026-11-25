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

class MessageReply implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
    public int $message_id,
    public int $conversation_id,
    public int $sender_id,
    public int $receiver_id,
    public string $reply_message,
    public int $is_read,
    public Carbon $created_at,
    public string $sender_name,
    public string $message,
    public bool $link,
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
            new PrivateChannel('users.'.$this->receiver_id),
        ];
    }
    public function broadcastWith():array
    {
        return [
                "message_id" =>$this->message_id,
                "conversation_id"=>$this->conversation_id,
                "sender_id" =>$this->sender_id,
                "receiver_id" =>$this->receiver_id,
                "reply_message" =>$this->reply_message,
                "is_read" =>$this->is_read,
                "created_at" =>$this->created_at,
                "sender_name"=>$this->sender_name,
                "message" =>$this->message,
                "link" =>$this->link,
        ];
    }
    public function broadcastAs():string
    {
            return "message.reply";
    }
}
