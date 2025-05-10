<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('default_locale'),
                Forms\Components\TextInput::make('default_platform'),
                Forms\Components\TextInput::make('site_logo'),
                Forms\Components\TextInput::make('header_code'),
                Forms\Components\TextInput::make('footer_code'),
                Forms\Components\TextInput::make('home_page_ad'),
                Forms\Components\TextInput::make('home_page_ad_2'),
                Forms\Components\TextInput::make('results_page_ad'),
                Forms\Components\TextInput::make('results_page_ad_2'),
                Forms\Components\TextInput::make('single_page_ad'),
                Forms\Components\TextInput::make('single_page_ad_2'),
                Forms\Components\TextInput::make('download_page_ad'),
                Forms\Components\TextInput::make('download_page_ad_2'),
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
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
