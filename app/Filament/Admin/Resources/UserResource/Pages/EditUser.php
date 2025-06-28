<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->visible(fn ($record) => $record->id !== 1)
            ->before(function (Actions\DeleteAction $action, User $record) {
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
            })      
          ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Prevent password update if empty
        if (empty($data['password'])) {
            unset($data['password']);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        //parent::afterSave();

        // If the authenticated user is editing their own password, refresh session to avoid logout
        if ($this->record->id === Auth::id()) {
            session()->put('password_hash_' . Auth::getDefaultDriver(), $this->record->getAuthPassword());
        }
    }
}
