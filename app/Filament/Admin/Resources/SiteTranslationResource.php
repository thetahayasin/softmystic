<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SiteTranslationResource\Pages;
use App\Models\SiteTranslation;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteTranslationResource extends Resource
{
    protected static ?string $model = SiteTranslation::class;

    protected static ?string $navigationIcon = 'heroicon-s-globe-alt';

    protected static ?string $navigationGroup = 'Site Settings';

    protected static ?int $navigationSort = 2;
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Language')
                ->schema([
                    Select::make('locale_id')
                        ->relationship('locale', 'name')
                        ->label('Locale')
                        ->required()
                        ->preload()
                        ->columnSpan(12), // Full span for the 'locale_id'
                ]),

                // Section for Static Translations
                Section::make('Static Translations')
                    ->schema([
                        TextInput::make('search_results')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Search Results Text'),
                        TextInput::make('category')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Category Text'),
                        TextInput::make('download_button')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Download Button Text'),
                        TextInput::make('footer_text')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Footer Text'),
                        TextInput::make('latest')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Latest Text'),
                        TextInput::make('popular')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Popular Text'),
                        TextInput::make('related')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Related Text'),
                        TextInput::make('download')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Download Text'),
                        TextInput::make('for')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('For Text'),
                        TextInput::make('free')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Free Text'),
                        TextInput::make('version')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Version Text'),
                    ])->columns(2),
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
