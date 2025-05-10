<?php

namespace App\Filament\Admin\Resources\SiteTranslationResource\Pages;

use App\Filament\Admin\Resources\SiteTranslationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSiteTranslations extends ListRecords
{
    protected static string $resource = SiteTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
