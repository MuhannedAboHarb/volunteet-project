<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VolunteerResource\Pages;
use App\Filament\Resources\VolunteerResource\RelationManagers;
use App\Models\Volunteer;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VolunteerResource extends Resource
{
    protected static ?string $model = Volunteer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                    ->label('First Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('last_name')
                    ->label('Last Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email()
                    ->maxLength(255),

                TextInput::make('age')
                    ->label('Age')
                    ->required()
                    ->numeric(),

                Select::make('gender')
                    ->label('Gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                        'Other' => 'Other',
                    ])
                    ->required(),

                Textarea::make('skills')
                    ->label('Skills')
                    ->nullable()
                    ->maxLength(500),

                FileUpload::make('cv_file') 
                    ->label('Upload CV')
                    ->directory('volunteers/cvs')
                    ->acceptedFileTypes(['application/pdf', 'application/msword'])
                    ->nullable(),
                
                FileUpload::make('cover_letter_file') 
                    ->label('Upload Cover Letter')
                    ->acceptedFileTypes(['application/pdf', 'application/msword'])
                    ->nullable(),

                Checkbox::make('has_previous_jobs')
                    ->label('Has Previous Jobs?')
                    ->default(false)
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $state ? $set('previous_jobs_details', '') : null),

                Textarea::make('previous_jobs_details')
                    ->label('Previous Jobs Details')
                    ->nullable()
                    ->hidden(fn (callable $get) => !$get('has_previous_jobs')),

                TextInput::make('phone')
                    ->label('Primary Phone Number')
                    ->numeric()
                    ->required()
                    ->maxLength(20),

                TextInput::make('address')
                    ->label('Current Address')
                    ->required()
                    ->maxLength(255),

                Checkbox::make('has_disability_or_chronic_illness')
                    ->label('Has Disability or Chronic Illness')
                    ->default(false)
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $state ? $set('disability_or_illness_details', '') : null),

                Textarea::make('disability_or_illness_details')
                    ->label('Disability or Illness Details')
                    ->nullable()
                    ->hidden(fn (callable $get) => !$get('has_disability_or_chronic_illness')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')->label('First Name')->sortable(),
                Tables\Columns\TextColumn::make('last_name')->label('Last Name')->sortable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->sortable(),
                Tables\Columns\TextColumn::make('age')->label('Age')->sortable(),
                Tables\Columns\TextColumn::make('gender')->label('Gender')->sortable(),
                Tables\Columns\TextColumn::make('skills')->label('Skills')->sortable(),
                Tables\Columns\TextColumn::make('address')->label('Address')->sortable(),
                Tables\Columns\TextColumn::make('phone')->label('Phone')->sortable(),
                Tables\Columns\IconColumn::make('has_previous_jobs')
                    ->label('Has Previous Jobs?')
                    ->boolean(),
                Tables\Columns\TextColumn::make('cv_file')
                    ->label('CV File')
                    ->formatStateUsing(fn ($state) => basename($state)),
                Tables\Columns\TextColumn::make('cover_letter_file')
                    ->label('Cover Letter')
                    ->formatStateUsing(fn ($state) => basename($state)),
            ])
            ->filters([/* Add any filters if needed */])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\ViewAction::make()->label('عرض'),
                Tables\Actions\DeleteAction::make()->label('حذق'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVolunteers::route('/'),
            'create' => Pages\CreateVolunteer::route('/create'),
            'edit' => Pages\EditVolunteer::route('/{record}/edit'),
        ];
    }
}
