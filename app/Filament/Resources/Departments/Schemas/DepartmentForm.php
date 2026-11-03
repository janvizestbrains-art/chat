<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
    ->components([
        Section::make('Department Details')
            ->description('Enter the basic information for this department.')
            ->icon('heroicon-o-building-office-2')
            ->schema([
                TextInput::make('name')
                    ->label('Department Name')
                    ->placeholder('e.g. Human Resources')

                    ->prefixIcon('heroicon-o-building-office')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Textarea::make('description')
                    ->label('Description')
                    ->required()
                    ->placeholder('Describe this department...')
                    ->rows(4)
                    ->maxLength(1000),

                Toggle::make('is_active')
                    ->label('Active Status')
                    ->helperText('Enable or disable this department.')
                    ->default(true)
                    ->required(),
            ]),
    ]);
    }
}
