<?php

namespace App\Filament\Resources\Employees\Pages;

use App\Filament\Resources\Employees\EmployeeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
    public function infolist(Schema $schema): Schema
{
    return $schema->components([

        Section::make('Employee Profile')
            ->schema([
                Grid::make(3)->schema([
                    ImageEntry::make('profile_photo')
                        ->label('Profile Photo')
                        ->disk('public')
                        ->circular()
                        ->imageHeight(120),

                    TextEntry::make('employee_code')
                        ->label('Employee Code')
                        ->weight('bold'),

                    TextEntry::make('employment_status')
                        ->label('Employment Status')
                        ->badge()
                        ->color(fn ($state) => match ($state) {
                            'active' => 'success',
                            'inactive' => 'danger',
                            default => 'gray',
                        }),
                ]),
            ]),

        Section::make('Personal Information')
            ->schema([
                Grid::make(3)->schema([
                    TextEntry::make('first_name')
                        ->label('First Name'),

                    TextEntry::make('last_name')
                        ->label('Last Name'),

                    TextEntry::make('date_of_birth')
                        ->label('Date of Birth')
                        ->date('d M Y'),

                    TextEntry::make('gender')
                        ->label('Gender'),
                ]),
            ]),

        Section::make('Contact & Address Information')
            ->schema([
                Grid::make(3)->schema([
                    TextEntry::make('email')
                        ->label('Email Address'),

                    TextEntry::make('phone')
                        ->label('Phone Number'),

                    TextEntry::make('address')
                        ->label('Address')
                        ->columnSpanFull(),

                    TextEntry::make('city')
                        ->label('City'),

                    TextEntry::make('state')
                        ->label('State'),

                    TextEntry::make('postal_code')
                        ->label('Postal Code'),

                    TextEntry::make('country')
                        ->label('Country'),
                ]),
            ]),

        Section::make('Employment Information')
            ->schema([
                Grid::make(3)->schema([
                    TextEntry::make('department.name')
                        ->label('Department'),

                    TextEntry::make('designation')
                        ->label('Designation'),

                    TextEntry::make('employment_type')
                        ->label('Employment Type'),

                    TextEntry::make('joining_date')
                        ->label('Joining Date')
                        ->date('d M Y'),

                    TextEntry::make('reporting_manager_id')
                        ->label('Reporting Manager ID'),
                ]),
            ]),

        Section::make('Emergency Contact Information')
            ->schema([
                Grid::make(3)->schema([
                    TextEntry::make('emergency_contact_name')
                        ->label('Contact Name'),

                    TextEntry::make('emergency_contact_phone')
                        ->label('Contact Phone'),

                    TextEntry::make('emergency_contact_relation')
                        ->label('Relationship'),
                ]),
            ]),

    ]);
}
}
