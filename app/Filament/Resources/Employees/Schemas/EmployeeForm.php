<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
      return $schema
    ->components([
        Section::make('Personal Information')
            ->description('Enter the employee’s personal details.')
            ->icon('heroicon-o-user')
            ->columns(2)
            ->schema([

                FileUpload::make('profile_photo')
                    ->label('Profile Photo')
                    ->image()
                    ->disk('public')
                    ->directory('employees')
                    ->visibility('public')
                    ->imageEditor()
                    ->maxSize(2048)
                    ->columnSpanFull(),

                TextInput::make('first_name')
                    ->label('First Name')
                    ->placeholder('Enter first name')
                    ->required()
                    ->maxLength(255)
                    ->rules(['regex:/^[\pL\pM\s\'-]+$/u']),

                TextInput::make('last_name')
                    ->label('Last Name')
                    ->placeholder('Enter last name')
                    ->required()
                    ->maxLength(255)
                    ->rules(['regex:/^[\pL\pM\s\'-]+$/u']),

                TextInput::make('email')
                    ->label('Email Address')
                    ->placeholder('employee@example.com')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                TextInput::make('phone')
                    ->label('Phone Number')
                    ->placeholder('Enter phone number')
                    ->tel()
                    ->maxLength(20)
                    ->rules(['nullable', 'regex:/^[0-9+\-\s()]+$/']),

                DatePicker::make('date_of_birth')
                    ->label('Date of Birth')
                    ->native(false)
                    ->maxDate(now()),

                Select::make('gender')
                    ->label('Gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                        'Other' => 'Other',
                    ])
                    ->native(false)
                    ->placeholder('Select gender'),
            ]),

        Section::make('Address Information')
            ->description('Enter the employee’s residential address.')
            ->icon('heroicon-o-map-pin')
            ->columns(2)
            ->schema([
                Textarea::make('address')
                    ->label('Street Address')
                    ->placeholder('Enter house number, street, or area')
                    ->rows(3)
                    ->maxLength(1000)
                    ->columnSpanFull(),

                TextInput::make('city')
                    ->label('City')
                    ->placeholder('Enter city')
                    ->maxLength(100),

                TextInput::make('state')
                    ->label('State')
                    ->placeholder('Enter state')
                    ->maxLength(100),

                TextInput::make('postal_code')
                    ->label('Postal Code')
                    ->placeholder('Enter postal code')
                    ->maxLength(20),

                TextInput::make('country')
                    ->label('Country')
                    ->placeholder('Enter country')
                    ->maxLength(100),
            ]),

        Section::make('Employment Information')
            ->description('Configure the employee’s department and job details.')
            ->icon('heroicon-o-briefcase')
            ->columns(2)
            ->schema([
                Select::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(),

                TextInput::make('designation')
                    ->label('Job Designation')
                    ->placeholder('e.g. Frontend Developer')
                    ->required()
                    ->maxLength(255),

                Select::make('employment_type')
                    ->label('Employment Type')
                    ->options([
                        'Full-time' => 'Full-time',
                        'Part-time' => 'Part-time',
                        'Contract' => 'Contract',
                        'Intern' => 'Intern',
                    ])
                    ->default('Full-time')
                    ->native(false)
                    ->required(),

                DatePicker::make('joining_date')
                    ->label('Joining Date')
                    ->native(false)
                     ->maxDate(now())
                    ->required(),
                  Select::make('reporting_manager_id')
                    ->label('Reporting Manager')
                    ->relationship('reportingManager', 'first_name')
                    ->getOptionLabelFromRecordUsing(
                        fn ($record) => trim(
                            $record->first_name . ' ' . $record->last_name
                        )
                    )
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->placeholder('Select reporting manager')
                    ->nullable()
                    ->rules(['nullable', 'exists:employees,id']),
                Select::make('role')
    ->label('Select Role')
    ->options(
        \Spatie\Permission\Models\Role::pluck('name', 'name')
    )
    ->default('Employee')
    ->native(false)
    ->required(),

                Select::make('employment_status')
                    ->label('Employment Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'resigned' => 'Resigned',
                        'terminated' => 'Terminated',
                    ])
                    ->default('active')
                    ->native(false)
                    ->required(),
            ]),

        Section::make('Emergency Contact')
            ->description('Provide a contact person for emergencies.')
            ->icon('heroicon-o-phone')
            ->columns(2)
            ->schema([
                TextInput::make('emergency_contact_name')
                    ->label('Contact Person Name')
                    ->placeholder('Enter full name')
                    ->maxLength(255),

                TextInput::make('emergency_contact_phone')
                    ->label('Emergency Contact Number')
                    ->placeholder('Enter phone number')
                    ->tel()
                    ->maxLength(20)
                    ->rules(['nullable', 'regex:/^[0-9+\-\s()]+$/']),

                TextInput::make('emergency_contact_relation')
                    ->label('Relationship')
                    ->placeholder('e.g. Parent, Spouse, Sibling')
                    ->maxLength(100)
                    ->columnSpanFull(),
            ]),
    ]);
       }
}
