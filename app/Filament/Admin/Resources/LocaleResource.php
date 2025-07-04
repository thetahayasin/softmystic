<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LocaleResource\Pages;
use App\Models\Locale;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;


class LocaleResource extends Resource
{
    protected static ?string $model = Locale::class;

    protected static ?string $navigationIcon = 'heroicon-o-language';

    protected static ?string $navigationGroup = 'Site Settings';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Languages';

    protected static ?string $label = 'Language';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Add a Language Below') // Title for the section
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->label('Name')
                        ->minLength(3)
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, $set) {
                            $set('slug', Str::slug($state));
                        }),

                    TextInput::make('slug')
                        ->required()
                        ->minLength(2)
                        ->maxLength(255)
                        ->label('Slug')
                        ->helperText('Slug will be autogenerated from name')
                        ->unique(ignoreRecord: true),

                    TextInput::make('key')
                        ->required()
                        ->minLength(2)
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->label('Key'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->alignment('center')->searchable(),
                Tables\Columns\TextColumn::make('slug')->alignment('center'),
                Tables\Columns\TextColumn::make('key')->alignment('center')->searchable(),
                Tables\Columns\TextColumn::make('software_translations_count')
                                ->counts('softwareTranslations')
                                ->label('Softwares Translations')
                                ->badge()
                                ->alignment('center')
                                ->color('primary'),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->before(function (Tables\Actions\DeleteAction $action, Locale $record) {
                    if ($record->sitesetting()->exists()) {
                        Notification::make()
                            ->danger()
                            ->title('Failed to delete!')
                            ->body('This is the default language. Change in settings to delete this language.')
                            ->persistent()
                            ->send();
             
                            // This will halt and cancel the delete action modal.
                            $action->cancel();
                    }
                })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLocales::route('/'),
            'create' => Pages\CreateLocale::route('/create'),
            'edit' => Pages\EditLocale::route('/{record}/edit'),
        ];
    }
}
