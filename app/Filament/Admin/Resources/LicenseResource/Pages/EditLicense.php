<?php

namespace App\Filament\Admin\Resources\LicenseResource\Pages;

use App\Filament\Admin\Resources\LicenseResource;
use Filament\Resources\Pages\EditRecord;

class EditLicense extends EditRecord
{
    protected static string $resource = LicenseResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
