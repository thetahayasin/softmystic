<?php

namespace App\Filament\Admin\Resources\SiteTranslationResource\Pages;

use App\Filament\Admin\Resources\SiteTranslationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSiteTranslation extends CreateRecord
{
    protected static string $resource = SiteTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
