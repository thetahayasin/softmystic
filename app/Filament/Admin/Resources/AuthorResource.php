<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AuthorResource\Pages;
use App\Models\Author;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;


class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Author Details')
                ->description('Specify the author name, slug, website URL, and description.')
                ->schema([
                    TextInput::make('name')
                        ->label('Author Name')
                        ->required()
                        ->minLength(3)
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->live(onBlur: true) // trigger on blur or use 'true' for realtime
                        ->afterStateUpdated(function ($state, $set) {
                            $set('slug', Str::slug($state));
                        }),
                    
                    TextInput::make('slug')
                        ->label('Slug')
                        ->minLength(3)
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('Automatically generated from the author name. You can override it.'),
            
                    TextInput::make('url')
                        ->label('Author Url')
                        ->required()
                        ->url(),
            
                    TextArea::make('description')
                        ->label('Description (Optional)')
                        ->nullable()
                        ->columnSpanFull(),
                ])
                ->columns(2),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('url'),
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
                Tables\Actions\DeleteAction::make()->before(function (Tables\Actions\DeleteAction $action, Author $record) {
                    if ($record->softwares()->exists()) {
                        Notification::make()
                            ->danger()
                            ->title('Failed to delete!')
                            ->body('This author has softwares related to it first remove them.')
                            ->persistent()
                            ->send();
             
                            // This will halt and cancel the delete action modal.
                            $action->cancel();
                    }
                }),

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
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }
}
