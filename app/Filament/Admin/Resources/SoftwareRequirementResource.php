<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SoftwareRequirementResource\Pages;
use App\Models\SoftwareRequirement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SoftwareRequirementResource extends Resource
{
    protected static ?string $model = SoftwareRequirement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('software_id')->nullable()->relationship('software', 'name'),
                Forms\Components\Select::make('requirement_id')->nullable()->relationship('requirement', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

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
            'index' => Pages\ListSoftwareRequirements::route('/'),
            'create' => Pages\CreateSoftwareRequirement::route('/create'),
            'edit' => Pages\EditSoftwareRequirement::route('/{record}/edit'),
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
