<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'receiver_id',
        'sender_id',
        'message',
        'is_read',
        'read_at',
        'is_edited',
        'delete_for_me',
        'delete_for_everyone',
        'clear_for_sender',
        'clear_for_receiver',
        'reply_message_id',
        'link',
    ];
    protected function casts(): array
{
    return [
        'is_read' => 'boolean',
        'delete_for_me'=>'boolean',
        'delete_for_everyone'=>'boolean',
        'read_at' => 'datetime',
        'clear_for_sender'=>'boolean',
        'clear_for_receiver'=>'boolean',
        'link' =>'boolean',
    ];
}

    // Message belongs to one conversation
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    // Message belongs to one sender
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function attachments()
{
    return $this->hasMany(MessageAttachment::class);
}
public function reactions()
{
        return $this->hasMany(MessageReaction::class);
}
public function messagestar()
{
    return $this->hasOne(MessageStar::class);
}

public function messagepin()
{
    return $this->hasOne(MessagePin::class);
}

  public function replyMessage()
{
    return $this->belongsTo(Message::class, 'reply_message_id');
}

public function replies()
{
    return $this->hasMany(Message::class, 'reply_message_id');
}

}
