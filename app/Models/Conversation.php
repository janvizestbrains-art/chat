<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'name',
        'type',
    ];

    // Conversation has multiple participants
  public function participants()
{
    return $this->hasMany(ConversationParticipant::class);
}

    // Conversation has multiple messages
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
    public function latestMessage()
{
    return $this->hasOne(Message::class)->latestOfMany();
}
}
