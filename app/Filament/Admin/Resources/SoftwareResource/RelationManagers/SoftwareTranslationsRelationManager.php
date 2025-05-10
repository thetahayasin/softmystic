<?php

namespace App\Filament\Admin\Resources\SoftwareResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rule;


class SoftwareTranslationsRelationManager extends RelationManager
{
    protected static string $relationship = 'softwareTranslations';
    protected static ?string $title = 'Translations';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\Select::make('locale_id')
                                ->label('Locale')
                                ->relationship('locale', 'name')
                                ->required()
                                ->rules(function () {
                                    $softwareId = $this->ownerRecord->id;
                                    $translation = $this->getMountedTableActionRecord(); // the translation being edited (nullable)

                                    return [
                                        Rule::unique('software_translations', 'locale_id')
                                            ->where(fn ($query) => $query->where('software_id', $softwareId))
                                            ->ignore($translation?->id),
                                    ];
                            }),

                            Forms\Components\TextInput::make('tagline')
                                ->required()
                                ->minLength(5)
                                ->maxLength(255)
                                ->label('Tagline'),
                        ]),

                    Forms\Components\RichEditor::make('content')
                        ->label('Content')
                        ->required()
                        ->toolbarButtons([
                            'bold',
                            'bulletList',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ])
                        ->columnSpanFull(), // Full width

                    Forms\Components\RichEditor::make('change_log')
                        ->label('Change Log')
                        ->toolbarButtons([
                            'bold',
                            'bulletList',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ])
                        ->columnSpanFull(), // Full width

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('software_id')
            ->columns([
                Tables\Columns\TextColumn::make('locale.name')->label('Locale'),
                Tables\Columns\TextColumn::make('tagline')->searchable(),

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
