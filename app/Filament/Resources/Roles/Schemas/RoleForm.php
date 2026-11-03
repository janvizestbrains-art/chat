<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
             Section::make('Role')
            ->description('Provide a role details.')

            ->columns(1)
            ->schema([
                TextInput::make('name')
            ->label('Role Name')
            ->placeholder('Enter role name')
            ->required()
            ->unique(ignoreRecord: true)
            ->maxLength(255)
            ->alphaDash(),
             CheckboxList::make("permissions")
       ->label("All Permissions")
       ->relationship(titleAttribute:'name')
       ->columns('4')
       ->gridDirection('row')
       ->bulkToggleable(),

        TextInput::make('guard_name')
            ->default('web')
            ->required()
            ->dehydrated()
            ->hidden(),
            ]),






            ]);
    }
}
