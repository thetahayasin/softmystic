<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?string $navigationLabel = 'Users';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Account Information')
                ->schema([
                    TextInput::make('name')
                        ->label('Name')
                        ->required()
                        ->minLength(3),
            
                    TextInput::make('email')
                        ->label('Email Address')
                        ->required()
                        ->email()
                        ->unique(ignoreRecord: true),
                    Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->visible(fn ($livewire) => $livewire->record?->id !== 1)
                            ->required(),
                ]),
            
                Section::make('Password')
                    ->description('Set or change the user password')
                    ->schema([
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                            ->maxLength(255)
                            ->minLength(8)
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state)) // Only update if not empty
                            ->autocomplete('new-password'),
                
                        TextInput::make('password_confirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                            ->same('password')
                            ->autocomplete('new-password'),

                    ])
                    ->columns(2),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->query(fn () => User::query()->withCount('softwares'))
            ->columns([
                TextColumn::make('name')->alignment('center'),
                TextColumn::make('email')->alignment('center'),
                Tables\Columns\TextColumn::make('softwares_count')
                        ->counts('softwares')
                        ->label('Softwares')
                        ->badge()
                        ->alignment('center')
                        ->color('primary'),
                IconColumn::make('is_active')
                        ->label('Active')
                        ->boolean()
                        ->sortable(),



            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->visible(fn ($record) => $record->id !== 1)
                ->before(function (Tables\Actions\DeleteAction $action, User $record) {
                    if ($record->softwares()->exists()) {
                        Notification::make()
                            ->danger()
                            ->title('Failed to delete!')
                            ->body('This user has softwares related to it first remove them or deactivate the user')
                            ->persistent()
                            ->send();
             
                            // This will halt and cancel the delete action modal.
                            $action->cancel();
                    }
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
