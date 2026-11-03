<?php

namespace App\Filament\Resources\Notifications\Schemas;

use App\Models\Employee;
use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Casts\Attribute;

class NotificationForm
{
    public static function configure(Schema $schema): Schema
    {


return $schema
    ->components([
        Section::make('Notification Details')
            ->description('Enter the notification title and message.')
            ->icon('heroicon-o-bell')
            ->columns(2)
            ->schema([
                TextInput::make('title')
                    ->label('Notification Title')
                    ->placeholder('Enter notification title')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Description')
                    ->placeholder('Enter notification description')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
            ]),

        Section::make('Select Employees')
            ->description('Choose the active employees who should receive this notification.')
            ->icon('heroicon-o-users')
            ->schema([
                CheckboxList::make('user_ids')
                    ->label('Employees')
                    ->options(
                        Employee::where('employment_status', 'active')
                            ->pluck('first_name', 'user_id')
                            ->toArray()
                    )
                    ->columns(4)
                    ->gridDirection('row')
                    ->bulkToggleable()
                    ->required(),
            ]),
    ]);
    }

}
