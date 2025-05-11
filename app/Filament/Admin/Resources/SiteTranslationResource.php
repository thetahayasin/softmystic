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
                        ->unique(ignoreRecord:true)
                        ->preload()
                        ->searchable()
                        ->columnSpan(12), // Full span for the 'locale_id'
                ]),
                Section::make('SEO')
                ->description('You can use shortcodes from static translations for the site like [download], [free], [version]. For software/category/platform/author/license currently on page [software], [category], [platform], [author], [license] can be used. ')
                ->schema([
                    TextInput::make('home_meta_title')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Home Meta Title')
                        ->helperText('Title for the home page meta tag.'),
        
                    TextInput::make('home_meta_description')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Home Meta Description')
                        ->helperText('Description for the home page meta tag.'),
        
                    TextInput::make('category_meta_title')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Category Meta Title')
                        ->helperText('Title for category pages meta tag.'),
        
                    TextInput::make('category_meta_description')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Category Meta Description')
                        ->helperText('Description for category pages meta tag.'),
        
                    TextInput::make('search_meta_title')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Search Meta Title')
                        ->helperText('Title for search result pages meta tag.'),
        
                    TextInput::make('search_meta_description')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Search Meta Description')
                        ->helperText('Description for search result pages meta tag.'),
        
                    TextInput::make('download_meta_title')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Download Meta Title')
                        ->helperText('Title for download page meta tag.'),
        
                    TextInput::make('download_meta_description')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Download Meta Description')
                        ->helperText('Description for download page meta tag.'),
        
                    TextInput::make('single_meta_title')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Single Page Meta Title')
                        ->helperText('Title for single page meta tag.'),
        
                    TextInput::make('single_meta_description')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Single Page Meta Description')
                        ->helperText('Description for single page meta tag.'),
                ])->columns(2),



                // Section for Static Translations
                Section::make('Static Translations')
                    ->schema([
                        TextInput::make('search_results')
                            ->required()
                            ->minLength(3)
                            ->default('Results for')
                            ->maxLength(255)
                            ->label('Search Results Text'),
                        TextInput::make('category')
                            ->required()
                            ->default('Category')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Category Text'),
                        TextInput::make('download_button')
                            ->required()
                            ->default('Download')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Download Button Text'),
                        TextInput::make('footer_text')
                            ->required()
                            ->minLength(3)
                            ->default('Softimystic is a multiplatform appstore.')
                            ->maxLength(255)
                            ->label('Footer Text'),
                        TextInput::make('latest')
                            ->required()
                            ->default('Latest Apps')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Latest Text'),
                        TextInput::make('popular')
                            ->required()
                            ->default('Popular Apps')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Popular Text'),
                        TextInput::make('related')
                            ->required()
                            ->default('Related Apps')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Related Text'),
                        TextInput::make('download')
                            ->required()
                            ->default('Download')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Download Text'),
                        TextInput::make('for')
                            ->required()
                            ->default('for')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('For Text'),
                        TextInput::make('free')
                            ->required()
                            ->default('Free')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Free Text'),
                        TextInput::make('version')
                            ->required()
                            ->default('Version')
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
                Tables\Columns\TextColumn::make('locale.name')->label('Language'),
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
            'index' => Pages\ListSiteTranslations::route('/'),
            'create' => Pages\CreateSiteTranslation::route('/create'),
            'edit' => Pages\EditSiteTranslation::route('/{record}/edit'),
        ];
    }
}
