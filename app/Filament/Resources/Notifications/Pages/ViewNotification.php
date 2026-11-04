<?php

namespace App\Filament\Resources\Notifications\Pages;

use App\Filament\Resources\Notifications\NotificationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Models\User;
class ViewNotification extends ViewRecord
{
    protected static string $resource = NotificationResource::class;


    public function sender()
{
    return $this->belongsTo(User::class, 'sender_id');
}
}
