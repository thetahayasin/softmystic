<?php

namespace App\Filament\Admin\Resources\LocaleResource\Pages;

use App\Filament\Admin\Resources\LocaleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLocale extends CreateRecord
{
    protected static string $resource = LocaleResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
