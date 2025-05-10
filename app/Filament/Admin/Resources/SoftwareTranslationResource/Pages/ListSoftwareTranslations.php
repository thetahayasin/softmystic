<?php

namespace App\Filament\Admin\Resources\SoftwareTranslationResource\Pages;

use App\Filament\Admin\Resources\SoftwareTranslationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSoftwareTranslations extends ListRecords
{
    protected static string $resource = SoftwareTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
