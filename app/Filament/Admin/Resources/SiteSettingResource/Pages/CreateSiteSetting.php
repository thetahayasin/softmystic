<?php

namespace App\Filament\Admin\Resources\SiteSettingResource\Pages;

use App\Filament\Admin\Resources\SiteSettingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSiteSetting extends CreateRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
