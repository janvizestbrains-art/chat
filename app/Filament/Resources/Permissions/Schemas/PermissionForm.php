<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
         return $schema
            ->components([
             Section::make('Permission')
            ->description('Provide a Permission details.')

            ->columns(1)
            ->schema([
                TextInput::make('name')
            ->label('Permission Name')
            ->placeholder('e.g. View Users')
            ->required(),


        TextInput::make('guard_name')
            ->default('web')
            ->required()
            ->dehydrated()
            ->hidden(),
            ]),
            ]);
    }
}
