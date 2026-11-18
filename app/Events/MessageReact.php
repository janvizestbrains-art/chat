<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageReact implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(

    public int $message_id,
    public int $sender_id,
    public int $receiver_id,
    public string $react,
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
    public function broadcastAs():string
    {
        return 'message.react';
    }
    public function broadcastWith():array
    {
      $message = Message::with('reactions')->find($this->message_id);
       $reactions=[];
       foreach($message->reactions as $reaction)
        {
            $reactions[]=
            [
            'user_id' =>$reaction->user_id,
            'reaction'=>$reaction->reaction,
            ];
        }
        return [
            "message_id" =>$this->message_id,
            "reactions" =>$reactions,
        ];
    }
}
