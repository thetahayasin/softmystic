<?php

namespace App\Filament\Admin\Resources\PageResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rule;

class TranslationsRelationManager extends RelationManager
{
    protected static string $relationship = 'translations';

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
                                                Rule::unique('page_translations', 'locale_id')
                                                    ->where(fn ($query) => $query->where('page_id', $parentId))
                                                    ->ignore($editingRecord?->id),
                                            ];
                                        }),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->minLength(3)
                    ->maxLength(255),

                    Forms\Components\RichEditor::make('content')
                    ->required()
                    ->minLength(3)
                    ->columnSpanFull(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('content')
                ->formatStateUsing(fn ($state) => strip_tags($state))
                ->limit(50),
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
