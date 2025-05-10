<?php

namespace App\Filament\Admin\Resources\CategoryTranslationResource\Pages;

use App\Filament\Admin\Resources\CategoryTranslationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoryTranslation extends CreateRecord
{
    protected static string $resource = CategoryTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
