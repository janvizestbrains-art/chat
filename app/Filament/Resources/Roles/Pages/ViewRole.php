<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;
class ViewRole extends ViewRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
    public function infolist(Schema $schema): Schema
{
    return $schema->components([

        Section::make('Role Information')
            ->description('View role details.')
            ->schema([
                Grid::make(2)
                    ->schema([

                        TextEntry::make('name')
                            ->label('Role Name')
                            ->icon('heroicon-o-shield-check')
                            ->weight('bold'),

                        TextEntry::make('permissions_count')
                            ->label('Total Permissions')
                            ->state(fn ($record) => $record->permissions()->count())
                            ->badge()
                            ->color('info'),

                    ]),
            ]),

        Section::make('Assigned Permissions')
            ->description('All permissions assigned to this role.')
            ->schema([

                TextEntry::make('permissions')
                    ->label('Permissions')
                    ->state(fn ($record) => $record->permissions->pluck('name')->toArray())
                    ->badge()
                    ->color('success')
                    ->placeholder('No permissions assigned'),

            ]),

    ]);
}
}
