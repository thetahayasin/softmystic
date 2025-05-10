<?php

namespace App\Filament\Admin\Resources\SoftwareTranslationResource\Pages;

use App\Filament\Admin\Resources\SoftwareTranslationResource;
use Filament\Resources\Pages\EditRecord;

class EditSoftwareTranslation extends EditRecord
{
    protected static string $resource = SoftwareTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
