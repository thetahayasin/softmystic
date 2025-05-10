<?php

namespace App\Filament\Admin\Resources\LicenseTranslationResource\Pages;

use App\Filament\Admin\Resources\LicenseTranslationResource;
use Filament\Resources\Pages\EditRecord;

class EditLicenseTranslation extends EditRecord
{
    protected static string $resource = LicenseTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
