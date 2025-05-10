<?php

namespace App\Filament\Admin\Resources\SiteTranslationResource\Pages;

use App\Filament\Admin\Resources\SiteTranslationResource;
use Filament\Resources\Pages\EditRecord;

class EditSiteTranslation extends EditRecord
{
    protected static string $resource = SiteTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
