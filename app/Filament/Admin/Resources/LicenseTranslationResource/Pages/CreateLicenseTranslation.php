<?php

namespace App\Filament\Admin\Resources\LicenseTranslationResource\Pages;

use App\Filament\Admin\Resources\LicenseTranslationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLicenseTranslation extends CreateRecord
{
    protected static string $resource = LicenseTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
