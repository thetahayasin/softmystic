<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\CategoryResource\RelationManagers\CategoryTranslationsRelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-s-square-2-stack';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Category Details')
                ->description('Enter the slug here. Translations can be added below.')
                ->schema([
                    TextInput::make('slug')
                        ->required()
                        ->label('Slug')
                        ->unique()
                        ->maxLength(255)
                        ->minLength(3),

                ])            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn () => Category::query()->withCount('categoryTranslations'))
            ->columns([
                Tables\Columns\TextColumn::make('slug')->searchable(),
                Tables\Columns\TextColumn::make('category_translations_count')
                                ->counts('categoryTranslations')
                                ->label('Translations')
                                ->badge()
                                ->alignment('center')
                                ->color('primary'),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            CategoryTranslationsRelationManager::class,
        ];
    }
}
