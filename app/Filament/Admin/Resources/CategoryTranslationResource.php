<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CategoryTranslationResource\Pages;
use App\Models\CategoryTranslation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryTranslationResource extends Resource
{
    protected static ?string $model = CategoryTranslation::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->label('Name'),
                Forms\Components\TextInput::make('description')->label('Description'),
                Forms\Components\Select::make('locale_id')->nullable()->relationship('locale', 'name'),
                Forms\Components\Select::make('category_id')->nullable()->relationship('category', 'slug'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('description')->searchable(),

            ])
            ->filters([

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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategoryTranslations::route('/'),
            'create' => Pages\CreateCategoryTranslation::route('/create'),
            'edit' => Pages\EditCategoryTranslation::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function canAccess(): bool
    {
        return false;
    }
}
