<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;

class Activity extends Model
{
    protected $fillable = [
        "user_id",
        "actor_id",
        "message_id",
        "conversation_id",
        "type",
        "content",
        "is_read",
    ];
    #[Override]
    protected function casts()
    {
        return[
            "is_read" =>"boolean",
        ];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function actor()
    {
        return $this->belongsTo(User::class);
    }
    public function message()
    {
        return $this->belongsTo(Message::class);
    }
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

}
