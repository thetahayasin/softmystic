<?php

namespace App\Filament\Admin\Resources\CategoryTranslationResource\Pages;

use App\Filament\Admin\Resources\CategoryTranslationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryTranslations extends ListRecords
{
    protected static string $resource = CategoryTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
