<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationResource\Pages;
use App\Filament\Resources\ApplicationResource\RelationManagers;
use App\Models\Application;
use App\Models\Post;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                ->label('Applicant')
                ->options(User::all()->pluck('name', 'id'))
                ->required(),

            Select::make('job_id')
                ->label('Job')
                ->options(Post::all()->pluck('title', 'id'))
                ->required(),

            Textarea::make('cover_letter')
                ->label('Cover Letter')
                ->required(),

            Select::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'accepted' => 'Accepted',
                    'rejected' => 'Rejected',
                ])
                ->default('pending')
                ->required(),

            TextInput::make('interview_date')
                ->label('Interview Date')
                ->nullable()
                ->date(),

            Textarea::make('reason_for_rejection')
                ->label('Reason for Rejection')
                ->nullable()
                ->hidden(fn (callable $get) => $get('status') != 'rejected'),

    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Applicant')->sortable(),
                Tables\Columns\TextColumn::make('job.title')->label('Job Title')->sortable(),
                Tables\Columns\TextColumn::make('cover_letter')->label('Cover Letter')->sortable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->sortable(),
                Tables\Columns\TextColumn::make('interview_date')->label('Interview Date')->sortable(),
                Tables\Columns\TextColumn::make('reason_for_rejection')->label('Rejection Reason')->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('status')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'pending'))
                    ->label('Pending'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}
