<?php

namespace App\Filament\Admin\Resources\LicenseTranslationResource\Pages;

use App\Filament\Admin\Resources\LicenseTranslationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLicenseTranslations extends ListRecords
{
    protected static string $resource = LicenseTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
