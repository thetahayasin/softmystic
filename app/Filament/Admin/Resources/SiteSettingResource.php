<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Navigation\Breadcrumb;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-s-cog-6-tooth';

    protected static ?string $navigationGroup = 'Site Settings';

    protected static ?int $navigationSort = 1;
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Tabs for organizing different settings
                Forms\Components\Tabs::make('Settings')
                    ->tabs([
    
                        // Site Settings Tab
                        Forms\Components\Tabs\Tab::make('Site Settings')
                            ->schema([
                                Forms\Components\TextInput::make('site_name')
                                ->required()
                                ->maxLength(255),

                                Forms\Components\FileUpload::make('site_logo')
                                    ->nullable()
                                    ->imagePreviewHeight('200')
                                    ->getUploadedFileNameForStorageUsing(fn ($file) => 'site_logo.' . $file->getClientOriginalExtension())
                                    ->directory('site_images')
                                    ->preserveFilenames()
                                    ->maxSize(20) 
                                    ->helperText('Logo image should be in webp format and max filesize is 20KB. 320x60 recommended resolution')
                                    ->acceptedFileTypes(['image/webp'])
                                    ->label('Site Logo'),

                                Forms\Components\FileUpload::make('site_favicon')
                                    ->nullable()
                                    ->imagePreviewHeight('200')
                                    ->getUploadedFileNameForStorageUsing(fn ($file) => 'site_favicon.' . $file->getClientOriginalExtension())
                                    ->directory('site_images')
                                    ->preserveFilenames()
                                    ->maxSize(20) 
                                    ->helperText('Favicon image should be in ico format and max filesize is 20KB. 48x48 recommended resolution')
                                    ->acceptedFileTypes([
                                        'image/x-icon',
                                        'image/vnd.microsoft.icon',
                                        'application/x-ico',
                                        'image/ico',
                                        '.ico'
                                    ]) // Cover all potential MIME types
                                    ->label('Site Favicon'),
                                    
                                Forms\Components\Select::make('locale_id')
                                    ->required()
                                    ->relationship('locale', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->label('Default Language')
                                    ->helperText('The default language for the site.'),
    
                                Forms\Components\Select::make('platform_id')
                                    ->required()
                                    ->preload()
                                    ->searchable()
                                    ->relationship('platform', 'name')
                                    ->label('Default Platform')
                                    ->helperText('The default platform setting for the site.'),
    
    
                                Forms\Components\Textarea::make('header_code')
                                    ->nullable()
                                    ->label('Header Code')
                                    ->helperText('Custom HTML/JS code to be inserted inside the <head> tag.'),
    
                                Forms\Components\Textarea::make('footer_code')
                                    ->nullable()
                                    ->label('Footer Code')
                                    ->helperText('Custom HTML/JS code to be inserted inside the <footer> tag.'),
                            ]),
    
                        // Advertisement Settings Tab
                        Forms\Components\Tabs\Tab::make('Advertisement Settings')
                            ->schema([
                                Forms\Components\TextArea::make('home_page_ad')
                                    ->nullable()
                                    ->maxLength(255)
                                    ->label('Home Page Ad')
                                    ->helperText('Ad content for the home page.'),
    
                                Forms\Components\TextArea::make('home_page_ad_2')
                                    ->nullable()
                                    ->maxLength(255)
                                    ->label('Home Page Ad 2')
                                    ->helperText('Second ad content for the home page.'),
    
                                Forms\Components\TextArea::make('results_page_ad')
                                    ->nullable()
                                    ->maxLength(255)
                                    ->label('Results Page Ad')
                                    ->helperText('Ad content for the results page.'),
    
                                Forms\Components\TextArea::make('results_page_ad_2')
                                    ->nullable()
                                    ->maxLength(255)
                                    ->label('Results Page Ad 2')
                                    ->helperText('Second ad content for the results page.'),
    
                                Forms\Components\TextArea::make('single_page_ad')
                                    ->nullable()
                                    ->maxLength(255)
                                    ->label('Single Page Ad')
                                    ->helperText('Ad content for the single page.'),
    
                                Forms\Components\TextArea::make('single_page_ad_2')
                                    ->nullable()
                                    ->maxLength(255)
                                    ->label('Single Page Ad 2')
                                    ->helperText('Second ad content for the single page.'),
    
                                Forms\Components\TextArea::make('download_page_ad')
                                    ->nullable()
                                    ->maxLength(255)
                                    ->label('Download Page Ad')
                                    ->helperText('Ad content for the download page.'),
    
                                Forms\Components\TextArea::make('download_page_ad_2')
                                    ->nullable()
                                    ->maxLength(255)
                                    ->label('Download Page Ad 2')
                                    ->helperText('Second ad content for the download page.'),
                            ])
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('default_locale')->searchable(),
                Tables\Columns\TextColumn::make('default_platform')->searchable(),
                Tables\Columns\TextColumn::make('site_logo')->searchable(),
                Tables\Columns\TextColumn::make('header_code')->searchable(),
                Tables\Columns\TextColumn::make('footer_code')->searchable(),
                Tables\Columns\TextColumn::make('home_page_ad')->searchable(),
                Tables\Columns\TextColumn::make('home_page_ad_2')->searchable(),
                Tables\Columns\TextColumn::make('results_page_ad')->searchable(),
                Tables\Columns\TextColumn::make('results_page_ad_2')->searchable(),
                Tables\Columns\TextColumn::make('single_page_ad')->searchable(),
                Tables\Columns\TextColumn::make('single_page_ad_2')->searchable(),
                Tables\Columns\TextColumn::make('download_page_ad')->searchable(),
                Tables\Columns\TextColumn::make('download_page_ad_2')->searchable(),
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
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true; // Keep in sidebar if needed
    }

    public static function getNavigationUrl(): string
    {
        // This will ensure that the link always goes to the edit page for the first record
        $siteSettings = SiteSetting::first(); // Get the first record
        return static::getUrl('edit', ['record' => $siteSettings->id]);
    }


}
