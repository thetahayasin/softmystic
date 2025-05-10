<?php

namespace App\Filament\Admin\Resources\LocaleResource\Pages;

use App\Filament\Admin\Resources\LocaleResource;
use Filament\Resources\Pages\EditRecord;

class EditLocale extends EditRecord
{
    protected static string $resource = LocaleResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
