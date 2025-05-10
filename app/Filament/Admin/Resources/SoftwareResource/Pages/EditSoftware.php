<?php

namespace App\Filament\Admin\Resources\SoftwareResource\Pages;

use App\Filament\Admin\Resources\SoftwareResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;


class EditSoftware extends EditRecord
{
    protected static string $resource = SoftwareResource::class;

    public function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->record; // Get current record being updated

        // If editing an existing record AND the logo is being changed
        if ($record && $record->logo !== $data['logo']) {
            if ($record->logo && Storage::disk('public')->exists($record->logo)) {
                Storage::disk('public')->delete($record->logo); // delete old logo
            }
        }
    
        // Ensure the user_id is set (you can skip this if it's already handled elsewhere)
        $data['user_id'] = auth()->id();
    
        return $data;
    }


    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
