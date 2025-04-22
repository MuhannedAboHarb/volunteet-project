<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobApplicationResource\Pages;
use App\Models\JobApplication;
use App\Models\Post;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;

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
                    ->options(Post::where('status', 'مفعلة')->pluck('title', 'id')) // عرض الوظائف المفعلة فقط
                    ->required(),

                FileUpload::make('cover_letter')
                    ->label('Cover Letter')
                    ->required(),

                FileUpload::make('cv')
                    ->label('CV')
                    ->required(),

                Textarea::make('cover_letter_text')
                    ->label('Cover Letter Text')
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Applicant')->sortable(),
                Tables\Columns\TextColumn::make('job.title')->label('Job Title')->sortable(), // عرض عنوان الوظيفة
                Tables\Columns\TextColumn::make('cover_letter')->label('Cover Letter')->sortable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->sortable(),
            ])
            ->actions([
                // زر "Apply" للتقديم على الوظيفة
                Tables\Actions\Action::make('Apply')
                    ->label('تقديم على الوظيفة')
                    ->action(fn ($record) => JobApplication::create([
                        'user_id' => auth()->id(),
                        'job_id' => $record->job_id,
                        'status' => 'pending', // الحالة تكون مبدئية
                    ]))
                    ->color('success'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ])
                    ->label('Filter by Status'),
            ])
            ->bulkActions([ // يمكن إضافة إجراءات جماعية هنا حسب الحاجة
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
            'index' => Pages\ListJobApplications::route('/'),
            'create' => Pages\CreateJobApplication::route('/create'),
            'edit' => Pages\EditJobApplication::route('/{record}/edit'),
        ];
    }
}
