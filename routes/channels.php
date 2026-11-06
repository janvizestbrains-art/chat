<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('users.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
Broadcast::channel('online', function($user)
{
    return [
        "id"=>$user->id,
        "name" =>$user->name,
    ];
});
