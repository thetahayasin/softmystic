<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RequirementResource\Pages;
use App\Models\Requirement;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RequirementResource extends Resource
{
    protected static ?string $model = Requirement::class;

    protected static ?string $navigationIcon = 'heroicon-s-square-3-stack-3d';

    protected static ?string $navigationGroup = 'Management';

    protected static ?string $navigationLabel = 'Requirements';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Software Requirements')
                ->description('Enter the requirements of the software like Windows 10, Android 11, or other system requirements.')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->label('Name')
                        ->minLength(3)
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                ])
                ->columns(1),            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
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
            'index' => Pages\ListRequirements::route('/'),
            'create' => Pages\CreateRequirement::route('/create'),
            'edit' => Pages\EditRequirement::route('/{record}/edit'),
        ];
    }
}
