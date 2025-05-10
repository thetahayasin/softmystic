<?php

namespace App\Filament\Admin\Resources\AuthorResource\Pages;

use App\Filament\Admin\Resources\AuthorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAuthor extends CreateRecord
{
    protected static string $resource = AuthorResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
