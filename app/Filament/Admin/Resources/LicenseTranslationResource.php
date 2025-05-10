<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LicenseTranslationResource\Pages;
use App\Models\LicenseTranslation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LicenseTranslationResource extends Resource
{
    protected static ?string $model = LicenseTranslation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->label('Name'),
                Forms\Components\TextInput::make('description')->required()->label('Description'),
                Forms\Components\Select::make('locale_id')->nullable()->relationship('locale', 'name'),
                Forms\Components\Select::make('license_id')->nullable()->relationship('license', 'slug'),
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
            'index' => Pages\ListLicenseTranslations::route('/'),
            'create' => Pages\CreateLicenseTranslation::route('/create'),
            'edit' => Pages\EditLicenseTranslation::route('/{record}/edit'),
        ];
    }
}
