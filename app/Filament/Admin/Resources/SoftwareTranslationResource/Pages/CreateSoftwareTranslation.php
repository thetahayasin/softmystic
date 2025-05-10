<?php

namespace App\Filament\Admin\Resources\SoftwareTranslationResource\Pages;

use App\Filament\Admin\Resources\SoftwareTranslationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSoftwareTranslation extends CreateRecord
{
    protected static string $resource = SoftwareTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
