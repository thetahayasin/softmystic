<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SiteTranslationResource\Pages;
use App\Models\SiteTranslation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteTranslationResource extends Resource
{
    protected static ?string $model = SiteTranslation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('home_meta_title'),
                Forms\Components\TextInput::make('home_meta_description'),
                Forms\Components\TextInput::make('category_meta_title'),
                Forms\Components\TextInput::make('category_meta_description'),
                Forms\Components\TextInput::make('search_meta_title'),
                Forms\Components\TextInput::make('search_meta_description'),
                Forms\Components\TextInput::make('download_meta_title'),
                Forms\Components\TextInput::make('download_meta_description'),
                Forms\Components\TextInput::make('single_meta_title'),
                Forms\Components\TextInput::make('single_meta_description'),
                Forms\Components\TextInput::make('search_results'),
                Forms\Components\TextInput::make('category'),
                Forms\Components\TextInput::make('download_button'),
                Forms\Components\TextInput::make('footer_text'),
                Forms\Components\TextInput::make('latest'),
                Forms\Components\TextInput::make('popular'),
                Forms\Components\TextInput::make('related'),
                Forms\Components\TextInput::make('download'),
                Forms\Components\TextInput::make('for'),
                Forms\Components\TextInput::make('free'),
                Forms\Components\TextInput::make('version'),
                Forms\Components\Select::make('locale_id')->nullable()->relationship('locale', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('home_meta_title')->searchable(),
                Tables\Columns\TextColumn::make('home_meta_description')->searchable(),
                Tables\Columns\TextColumn::make('category_meta_title')->searchable(),
                Tables\Columns\TextColumn::make('category_meta_description')->searchable(),
                Tables\Columns\TextColumn::make('search_meta_title')->searchable(),
                Tables\Columns\TextColumn::make('search_meta_description')->searchable(),
                Tables\Columns\TextColumn::make('download_meta_title')->searchable(),
                Tables\Columns\TextColumn::make('download_meta_description')->searchable(),
                Tables\Columns\TextColumn::make('single_meta_title')->searchable(),
                Tables\Columns\TextColumn::make('single_meta_description')->searchable(),
                Tables\Columns\TextColumn::make('search_results')->searchable(),
                Tables\Columns\TextColumn::make('category')->searchable(),
                Tables\Columns\TextColumn::make('download_button')->searchable(),
                Tables\Columns\TextColumn::make('footer_text')->searchable(),
                Tables\Columns\TextColumn::make('latest')->searchable(),
                Tables\Columns\TextColumn::make('popular')->searchable(),
                Tables\Columns\TextColumn::make('related')->searchable(),
                Tables\Columns\TextColumn::make('download')->searchable(),
                Tables\Columns\TextColumn::make('for')->searchable(),
                Tables\Columns\TextColumn::make('free')->searchable(),
                Tables\Columns\TextColumn::make('version')->searchable(),

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
            'index' => Pages\ListSiteTranslations::route('/'),
            'create' => Pages\CreateSiteTranslation::route('/create'),
            'edit' => Pages\EditSiteTranslation::route('/{record}/edit'),
        ];
    }
}
