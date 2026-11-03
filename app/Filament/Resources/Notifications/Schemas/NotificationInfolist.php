<?php

namespace App\Filament\Resources\Notifications\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NotificationInfolist
{
    public static function configure(Schema $schema): Schema
    {
return $schema
    ->components([
        Section::make('Notification Details')
            ->description('Information about the notification.')
            ->icon('heroicon-o-bell')
            ->columns(2)
            ->schema([
                TextEntry::make('title')
                    ->label('Notification Title')
                    ->icon('heroicon-o-megaphone'),

                TextEntry::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('description')
                    ->label('Description')
                    ->columnSpanFull(),

                TextEntry::make('user_names')
                    ->label('Selected Employees')
                    ->icon('heroicon-o-users')
                    ->columnSpanFull(),
            ]),

        Section::make('Record Information')
            ->description('Notification record timestamps.')
            ->icon('heroicon-o-clock')
            ->columns(2)
            ->schema([
                TextEntry::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->placeholder('-'),
            ]),
    ]);
    }
}
