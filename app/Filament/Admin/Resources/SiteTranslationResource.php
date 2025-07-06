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

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

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


                Section::make('Global Translations')
                ->description('Specify Your Global Translations')
                ->schema([
                    TextInput::make('hero_title')
                        ->required()
                        ->maxLength(255)
                        ->label('Home Hero Title')
                        ->helperText('Title for the home page hero card.'),
        
                    TextInput::make('hero_text')
                        ->required()
                        ->maxLength(255)
                        ->label('Home Hero Text')
                        ->helperText('Text for the home page hero card.'),
                    TextInput::make('featured_apps')
                        ->required()
                        ->maxLength(255)
                        ->label('Home Featured Section Text')
                        ->helperText('Text for the home page Featured Apps section.'),
                    TextInput::make('latest_updates')
                        ->required()
                        ->maxLength(255)
                        ->label('Home Latest Updates Section Text')
                        ->helperText('Text for the home page Latest Updates section.'),
                    TextInput::make('new_releases')
                        ->required()
                        ->maxLength(255)
                        ->label('Home New Releases Section Text')
                        ->helperText('Text for the home page New Releases Apps section.'),
                    TextInput::make('trending_apps')
                        ->required()
                        ->maxLength(255)
                        ->label('Home Trending Section Text')
                        ->helperText('Text for the home page Trending Apps section.'),
                    TextInput::make('related')
                        ->required()
                        ->default('Single Page Related Apps Section Text')
                        ->minLength(3)
                        ->maxLength(255)
                        ->helperText('Text for the single page Related Apps section.')
                        ->label('Single Page Related Apps Section Text'),
                    TextInput::make('download_button')
                        ->required()
                        ->default('Download Now')
                        ->minLength(3)
                        ->maxLength(255)
                        ->label('Site Wide Download Button Text'),
                    TextInput::make('buy_now')
                        ->required()
                        ->default('Buy Now')
                        ->minLength(3)
                        ->maxLength(255)
                        ->label('Site Wide Buy Now Button Text'),
                    TextInput::make('footer_text')
                        ->required()
                        ->minLength(3)
                        ->default('Softimystic is a multiplatform appstore.')
                        ->maxLength(255)
                        ->label('Site Wide Footer Copyright Text'),

                    TextInput::make('nothing_found')
                        ->required()
                        ->maxLength(255)
                        ->label('No Record Found Text')

                ])->columns(2),

                Section::make('SEO')
                ->description('Some fields can use shortcodes from Static Translations / Shortcodes given below.')
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
                        ->label('Category Meta Title - [Short Codes can be used]')
                        ->helperText('Title for category pages meta tag. For current category use shortcodes [category_name] and [category_description]'),
        
                    TextInput::make('category_meta_description')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Category Meta Description - [Short Codes can be used]')
                        ->helperText('Description for category pages meta tag. For current category use shortcodes [category_name] and [category_description]'),
        
                    TextInput::make('search_meta_title')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Search Meta Title - [Short Codes can be used]')
                        ->helperText('Title for search result pages meta tag. For current search query use shortcode [search_query]'),
        
                    TextInput::make('search_meta_description')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Search Meta Description - [Short Codes can be used]')
                        ->helperText('Description for search result pages meta tag. For current search query use shortcode [search_query]'),
        
                    TextInput::make('download_meta_title')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Downloading Meta Title - [Short Codes can be used]')
                        ->helperText('Additional Shortcodes available: [software_name], [software_Description], [software_tagline], [year], [software_version], [software_platform]'),
        
                    TextInput::make('download_meta_description')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Downloading Meta Description - [Short Codes can be used]')
                        ->helperText('Additional Shortcodes available: [software_name], [software_Description], [software_tagline], [year], [software_version], [software_platform]'),
        
                    TextInput::make('single_meta_title')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Single Page Meta Title - [Short Codes can be used]')
                        ->helperText('Additional Shortcodes available: [software_name], [software_Description], [software_tagline], [year], [software_version], [software_platform]'),
        
                    TextInput::make('single_meta_description')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Single Page Meta Description - [Short Codes can be used]')
                        ->helperText('Additional Shortcodes available: [software_name], [software_Description], [software_tagline], [year], [software_version], [software_platform]'),
                    TextInput::make('downloading_text')
                        ->nullable()
                        ->maxLength(255)
                        ->label('Downloading Page - [Short Codes can be used]')
                        ->helperText('Additional Shortcodes available: [software_name], [software_Description], [software_tagline], [year], [software_version], [software_platform]'),
                ])->columns(2),

                // Section for single Translations
                Section::make('Single Page Specific Translations')
                    ->description('These short codes can be used in single page')
                    ->schema([
                        TextInput::make('author')
                            ->required()
                            ->minLength(3)
                            ->default('Author')
                            ->maxLength(255)
                            ->label('Author text translation on single page'),
                        TextInput::make('license')
                            ->required()
                            ->default('License')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('License text translation on single page'),
                        TextInput::make('requirements')
                            ->required()
                            ->default('Requirements')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Requirements text translation on single page'),
                        TextInput::make('size')
                            ->required()
                            ->default('Size')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Size text translation on single page'),

                    ])->columns(2),

                // Section for Static Translations
                Section::make('Static Translations / Shortcodes')
                    ->description('These short codes can be used in meta titles and descriptions')
                    ->schema([
                        TextInput::make('search_results')
                            ->required()
                            ->minLength(3)
                            ->default('Results for')
                            ->maxLength(255)
                            ->label('Search Results Text [search_results]'),
                        TextInput::make('category')
                            ->required()
                            ->default('Category')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Category Text [category]'),
                        TextInput::make('latest')
                            ->required()
                            ->default('Latest Apps')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Latest Text [latest]'),
                        TextInput::make('popular')
                            ->required()
                            ->default('Popular Apps')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Popular Text [popular]'),
                        TextInput::make('download')
                            ->required()
                            ->default('Download')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Download Text [download]'),
                        TextInput::make('for')
                            ->required()
                            ->default('for')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('For Text [for]'),
                        TextInput::make('free')
                            ->required()
                            ->default('Free')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Free Text [free]'),
                        TextInput::make('version')
                            ->required()
                            ->default('Version')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Version Text [version]'),
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
