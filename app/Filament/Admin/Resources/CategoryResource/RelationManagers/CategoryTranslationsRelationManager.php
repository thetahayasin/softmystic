<?php

namespace App\Filament\Admin\Resources\CategoryResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;

class CategoryTranslationsRelationManager extends RelationManager
{
    protected static string $relationship = 'categoryTranslations';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

            Select::make('locale_id')
            ->required()
            ->relationship('locale', 'name')
            ->label('Locale')
            ->rules(function () {
                $parentId = $this->getOwnerRecord()->id;
                $editingRecord = $this->getMountedTableActionRecord();
        
                return [
                    Rule::unique('category_translations', 'locale_id')
                        ->where(fn ($query) => $query->where('category_id', $parentId))
                        ->ignore($editingRecord?->id),
                ];
            }),

            TextInput::make('name')
                ->required()
                ->minLength(3)
                ->maxLength(255)
                ->label('Name Translation'),
        
            Textarea::make('description')
                ->nullable()
                ->minLength(5)
                ->maxLength(255)
                ->label('Description Translation (Optional)')
                ->columnSpanFull(),
    
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Name Translation'),
                Tables\Columns\TextColumn::make('description')->label('Description Translation'),
                Tables\Columns\TextColumn::make('locale.name')->label('Locale'),

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
