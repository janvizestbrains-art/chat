<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessagePin extends Model
{
    protected $fillable = [
        "conversation_id",
        "message_id",
        "user_id",
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function conversation()
    {
            return $this->belongsTo(Conversation::class);
    }
}
