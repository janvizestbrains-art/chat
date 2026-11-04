<?php

namespace App\Filament\Resources\Notifications\Pages;

use App\Events\NotificationCreated;
use App\Filament\Resources\Notifications\NotificationResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Override;

class CreateNotification extends CreateRecord
{
    protected static string $resource = NotificationResource::class;

    #[Override]
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    public function afterCreate():void
{
    $notification=$this->record;
       $notification = $this->record;

        foreach ($notification->user_ids as $userId) {

            NotificationCreated::dispatch(
                (int) $userId,
                $notification->title,
                $notification->description,
                $notification->created_at
            );

        }
}

}
