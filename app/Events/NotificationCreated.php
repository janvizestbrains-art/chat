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
use Illuminate\Support\Carbon;

class NotificationCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public int $userId,
       public string $title,
       public string $description,
       public Carbon  $created_at,
       )
    {

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */

    //where should event be sent
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('users.'.$this->userId),
        ];
    }

    //what data should be sent
    public function broadcastWith():array
    {
        return [
            'user_id' =>$this->userId,
            "title"=>$this->title,
            "description"=>$this->description,
            "created_at" => $this->created_at->toISOString(),
        ];
    }


    //Event Name
    public function broadcastAs():string
    {
            return "notification.created";
    }
}
