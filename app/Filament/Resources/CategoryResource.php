<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rule;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Taxonomies';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * Get the Eloquent query for the resource.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Category Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->alphaDashNum()
                            ->unique(Category::class, 'slug', ignoreRecord: true)
                            ->rules(['regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'])
                            ->helperText('Unique identifier for URL. Auto-generated from name. Only lowercase letters, numbers, and hyphens allowed.'),

                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('icon')
                            ->options([
                                'heroicon-o-folder' => 'Folder',
                                'heroicon-o-tag' => 'Tag',
                                'heroicon-o-bookmark' => 'Bookmark',
                                'heroicon-o-flag' => 'Flag',
                                'heroicon-o-star' => 'Star',
                                'heroicon-o-heart' => 'Heart',
                                'heroicon-o-briefcase' => 'Briefcase',
                                'heroicon-o-academic-cap' => 'Academic Cap',
                                'heroicon-o-banknotes' => 'Banknotes',
                                'heroicon-o-cog' => 'Cog',
                                'heroicon-o-globe-alt' => 'Globe',
                                'heroicon-o-home' => 'Home',
                                'heroicon-o-light-bulb' => 'Light Bulb',
                                'heroicon-o-rocket-launch' => 'Rocket',
                                'heroicon-o-shield-check' => 'Shield',
                            ])
                            ->searchable()
                            ->default('heroicon-o-tag')
                            ->helperText('Select an icon to represent this category.'),

                        Forms\Components\Select::make('parent_id')
                            ->label('Parent Category')
                            ->relationship(
                                'parent',
                                'name',
                                fn (Builder $query, ?Model $record) => $query
                                    ->where('is_active', true)
                                    ->when($record, fn ($q) => $q->where('id', '!=', $record->id))
                            )
                            ->searchable()
                            ->preload()
                            ->placeholder('Select parent category (optional)')
                            ->helperText('Create a hierarchical structure by selecting a parent category.')
                            ->rules([
                                fn (?Model $record): \Closure => function (string $attribute, $value, \Closure $fail) use ($record) {
                                    if ($value && $record) {
                                        // Check for circular reference
                                        $parentId = $value;
                                        $visited = [$record->id];
                                        
                                        while ($parentId) {
                                            if (in_array($parentId, $visited)) {
                                                $fail('Circular reference detected. A category cannot be its own ancestor.');
                                                return;
                                            }
                                            $visited[] = $parentId;
                                            $parent = Category::find($parentId);
                                            $parentId = $parent?->parent_id;
                                        }
                                    }
                                },
                            ]),

                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(9999)
                            ->helperText('Order in which this category appears. Lower numbers appear first.'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Inactive categories will not be shown to users.'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon(fn (Category $record): string => $record->icon ?? 'heroicon-o-tag'),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable()
                    ->copyMessage('Slug copied to clipboard')
                    ->copyMessageDuration(1500),

                Tables\Columns\TextColumn::make('icon')
                    ->label('Icon')
                    ->formatStateUsing(fn (string $state): string => str_replace('heroicon-o-', '', $state))
                    ->badge()
                    ->color('gray')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Parent')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Root')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('jobs_count')
                    ->label('Jobs')
                    ->counts('jobs')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->placeholder('All Statuses'),

                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Parent Category')
                    ->relationship('parent', 'name', fn (Builder $query) => $query->whereNull('parent_id'))
                    ->searchable()
                    ->preload()
                    ->placeholder('All Categories'),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->authorize('deleteAny'),
                    Tables\Actions\RestoreBulkAction::make()
                        ->authorize('restoreAny'),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->authorize('forceDeleteAny'),

                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->authorize('updateAny')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                if (auth()->user()->can('update', $record)) {
                                    $record->update(['is_active' => true]);
                                }
                            });
                            Cache::forget('categories_count');
                        })
                        ->deselectRecordsAfterAction()
                        ->requiresConfirmation()
                        ->modalHeading('Activate selected categories')
                        ->modalDescription('Are you sure you want to activate the selected categories?')
                        ->modalSubmitActionLabel('Yes, activate'),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->authorize('updateAny')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                if (auth()->user()->can('update', $record)) {
                                    $record->update(['is_active' => false]);
                                }
                            });
                            Cache::forget('categories_count');
                        })
                        ->deselectRecordsAfterAction()
                        ->requiresConfirmation()
                        ->modalHeading('Deactivate selected categories')
                        ->modalDescription('Are you sure you want to deactivate the selected categories?')
                        ->modalSubmitActionLabel('Yes, deactivate'),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->emptyStateHeading('No categories found')
            ->emptyStateDescription('Create your first category to get started.')
            ->emptyStateIcon('heroicon-o-tag')
            ->reorderable('sort_order')
            ->defaultSort('sort_order', 'asc');
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return Cache::remember('categories_count', now()->addMinutes(5), function () {
            return (string) static::getModel()::where('is_active', true)->count();
        });
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug', 'description'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Parent' => $record->parent?->name ?? 'Root',
            'Status' => $record->is_active ? 'Active' : 'Inactive',
        ];
    }
}