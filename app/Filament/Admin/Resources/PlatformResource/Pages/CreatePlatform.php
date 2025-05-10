<?php

namespace App\Filament\Admin\Resources\PlatformResource\Pages;

use App\Filament\Admin\Resources\PlatformResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePlatform extends CreateRecord
{
    protected static string $resource = PlatformResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
