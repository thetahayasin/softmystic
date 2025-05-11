<?php

namespace App\Filament\Admin\Resources\LicenseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;

class LicenseTranslationsRelationManager extends RelationManager
{
    protected static string $relationship = 'licenseTranslations';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('locale_id')
                                        ->required()
                                        ->preload()
                                        ->label('Language')
                                        ->searchable()
                                        ->relationship('locale', 'name')
                                        ->rules(function () {
                                            $parentId = $this->getOwnerRecord()->id;
                                            $editingRecord = $this->getMountedTableActionRecord();
                                    
                                            return [
                                                Rule::unique('license_translations', 'locale_id')
                                                    ->where(fn ($query) => $query->where('license_id', $parentId))
                                                    ->ignore($editingRecord?->id),
                                            ];
                                        }),
                Forms\Components\TextInput::make('name')->required()->label('Name Translation')->minLength(3)->maxLength(255),
                Forms\Components\TextArea::make('description')->nullable()->label('Description Translation (Limit:255 characters)')->minLength(3)->maxLength(255)->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('locale.name')->label('Language'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
