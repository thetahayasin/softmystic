<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SoftwareTranslationResource\Pages;
use App\Models\SoftwareTranslation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SoftwareTranslationResource extends Resource
{
    protected static ?string $model = SoftwareTranslation::class;

    protected static ?string $navigationIcon = 'heroicon-s-language';

    protected static ?string $navigationGroup = 'Softwares';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tagline')->required()->label('Tagline'),
                Forms\Components\TextInput::make('content')->required()->label('Content'),
                Forms\Components\TextInput::make('change_log'),
                Forms\Components\Select::make('software_id')->nullable()->relationship('software', 'name'),
                Forms\Components\Select::make('locale_id')->nullable()->relationship('locale', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tagline')->searchable(),
                Tables\Columns\TextColumn::make('content')->searchable(),
                Tables\Columns\TextColumn::make('change_log')->searchable(),

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
            'index' => Pages\ListSoftwareTranslations::route('/'),
            'create' => Pages\CreateSoftwareTranslation::route('/create'),
            'edit' => Pages\EditSoftwareTranslation::route('/{record}/edit'),
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
