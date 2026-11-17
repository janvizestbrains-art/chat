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
use Illuminate\Support\Facades\Auth;
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
public function getLatestMessageAttribute()
{
    $authId = Auth::id();

    return Message::where(function ($query) use ($authId) {

        $query->where(function ($q) use ($authId) {
            $q->where('sender_id', $this->id)
            ->where("clear_for_receiver",false)
                ->where('receiver_id', $authId);

        })
        ->orWhere(function ($q) use ($authId) {
            $q->where('sender_id', $authId)
            ->where("clear_for_sender",false)
                ->where('receiver_id', $this->id);

        });

    })
    ->where(function ($query) use ($authId) {
        $query->where('delete_for_me', false)
            ->orWhere('sender_id', '!=', $authId);
    })

    ->where('delete_for_everyone', false)
    ->latest('created_at')
    ->first();
}

    public function reactions()
    {
        return $this->hasMany(MessageReaction::class);
    }
}
