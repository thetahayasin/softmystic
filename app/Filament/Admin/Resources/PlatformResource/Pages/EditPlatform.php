<?php

namespace App\Filament\Admin\Resources\PlatformResource\Pages;

use App\Filament\Admin\Resources\PlatformResource;
use Filament\Resources\Pages\EditRecord;

class EditPlatform extends EditRecord
{
    protected static string $resource = PlatformResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
