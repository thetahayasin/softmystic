<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LicenseResource\Pages;
use App\Models\License;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Admin\Resources\LicenseResource\RelationManagers\LicenseTranslationsRelationManager;


class LicenseResource extends Resource
{
    protected static ?string $model = License::class;

    protected static ?string $navigationIcon = 'heroicon-s-clipboard-document-check';

    protected static ?string $navigationGroup = 'Content Settings';

    protected static ?string $navigationLabel = 'Licenses';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\Section::make('License Info')
                    ->description('Enter the slug of the license here. Translations can be added below.')
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->label('Slug')
                            ->minLength(3)
                            ->maxLength(255),
                    ])
                    ->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')->searchable(),
                Tables\Columns\TextColumn::make('license_translations_count')
                                ->counts('licenseTranslations')
                                ->label('Translations')
                                ->badge()
                                ->alignment('center')
                                ->color('primary'),
                Tables\Columns\TextColumn::make('softwares_count')
                                ->counts('softwares')
                                ->label('Softwares')
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
            'index' => Pages\ListLicenses::route('/'),
            'create' => Pages\CreateLicense::route('/create'),
            'edit' => Pages\EditLicense::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            LicenseTranslationsRelationManager::class,
        ];
    }
}
