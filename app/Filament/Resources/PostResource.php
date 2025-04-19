<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $modelLabel = 'وظيفة';
    protected static ?string $pluralModelLabel = 'وظائف';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('المعلومات الأساسية')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('عنوان الوظيفة')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->label('الرابط المخصص')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->label('الوصف')
                            ->required()
                            ->columnSpanFull()
                            ->rows(5),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('التفاصيل المالية والموقع')
                    ->schema([
                        Forms\Components\TextInput::make('salary')
                            ->label('الراتب ($)')
                            ->numeric()
                            ->required()
                            ->prefix('$')
                            ->minValue(0),

                        Forms\Components\TextInput::make('location')
                            ->label('الموقع')
                            ->required()
                            ->maxLength(255)
                            ->hint('أدخل "remote" أو "عن بعد" للعمل عن بُعد'),

                        Forms\Components\Toggle::make('paid')
                            ->label('وظيفة مدفوعة')
                            ->required()
                            ->inline(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('نوع العقد وعمل عن بعد')
                    ->schema([
                        Forms\Components\Select::make('contract_type')
                            ->label('نوع العقد')
                            ->options([
                                'دوام كامل' => 'دوام كامل',
                                'دوام جزئي' => 'دوام جزئي',
                                'عقد مؤقت' => 'عقد مؤقت',
                                'عمل حر' => 'عمل حر',
                            ])
                            ->default('دوام كامل')
                            ->dehydrated(false),

                        Forms\Components\Toggle::make('remote_work')
                            ->label('عمل عن بعد')
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('يتم تحديده تلقائياً بناءً على حقل الموقع'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('تفاصيل العقد')
                    ->schema([
                        Forms\Components\Textarea::make('contract_details')
                            ->label('الشروط')
                            ->nullable()
                            ->columnSpanFull()
                            ->rows(3),
                    ]),

                Forms\Components\Section::make('إعدادات النشر')
                    ->schema([
                        Forms\Components\Select::make('company_id')
                            ->label('الشركة')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('اسم الشركة')
                                    ->required(),
                            ]),

                        Forms\Components\DatePicker::make('posted_at')
                            ->label('تاريخ النشر')
                            ->required()
                            ->default(now())
                            ->displayFormat('d/m/Y'),

                        Forms\Components\DatePicker::make('expires_at')
                            ->label('تاريخ الانتهاء')
                            ->required()
                            ->minDate(fn ($get) => $get('posted_at') ?: now())
                            ->displayFormat('d/m/Y'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Post $record) => Str::limit($record->description, 30)),

                Tables\Columns\TextColumn::make('company.name')
                    ->label('الشركة')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('salary')
                    ->label('الراتب')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\IconColumn::make('remote_work')
                    ->label('عن بعد')
                    ->boolean()
                    ->state(fn (Post $record) => $record->remote_work),

                Tables\Columns\TextColumn::make('contract_type')
                    ->label('نوع العقد')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'دوام كامل' => 'success',
                        'دوام جزئي' => 'info',
                        'عقد مؤقت' => 'warning',
                        'عمل حر' => 'primary',
                        default => 'gray',
                    })
                    ->state(fn (Post $record) => $record->contract_type),

                Tables\Columns\IconColumn::make('paid')
                    ->label('مدفوعة')
                    ->boolean(),

                Tables\Columns\TextColumn::make('posted_at')
                    ->label('النشر')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('expires_at')
                    ->label('الانتهاء')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('company')
                    ->relationship('company', 'name')
                    ->label('الشركة'),

                Tables\Filters\Filter::make('paid')
                    ->label('الوظائف المدفوعة')
                    ->query(fn ($query) => $query->where('paid', true)),

                Tables\Filters\Filter::make('remote_work')
                    ->label('عمل عن بعد')
                    ->query(fn ($query) => $query->where('location', 'like', '%remote%')
                        ->orWhere('location', 'like', '%عن بعد%')),

                Tables\Filters\SelectFilter::make('contract_type')
                    ->label('نوع العقد')
                    ->options([
                        'دوام كامل' => 'دوام كامل',
                        'دوام جزئي' => 'دوام جزئي',
                    ])
                    ->query(fn ($query, $data) => $query->when(
                        $data['value'],
                        fn ($query, $value) => $query->where('salary', $value === 'دوام كامل' ? '>' : '<=', 5000)
                    )),

                Tables\Filters\Filter::make('expired')
                    ->label('الوظائف المنتهية')
                    ->query(fn ($query) => $query->where('expires_at', '<', now())),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\ViewAction::make()->label('عرض'),
                Tables\Actions\DeleteAction::make()->label('حذق'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ])
            ->defaultSort('posted_at', 'desc')
            ->emptyStateHeading('لا توجد وظائف بعد')
            ->emptyStateDescription('انقر على "إضافة" لإنشاء وظيفة جديدة');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
