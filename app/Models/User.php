<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function employee(): HasOne
{
    return $this->hasOne(Employee::class);
}
public function notifications(): BelongsToMany
{
    return $this->belongsToMany(Notification::class)
        ->withTimestamps();
}
public function leaves(): HasMany
{
    return $this->hasMany(Leave::class);
}
public function conversationParticipants()
{
    return $this->hasMany(ConversationParticipant::class);
}

// User can send multiple messages
public function sentMessages(): HasMany
{
    return $this->hasMany(Message::class, 'sender_id');
}
public function receivedMessages()
{
    return $this->hasMany(Message::class, 'receiver_id');
}
}
