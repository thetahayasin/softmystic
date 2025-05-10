<?php

namespace App\Filament\Admin\Resources\RequirementResource\Pages;

use App\Filament\Admin\Resources\RequirementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRequirements extends ListRecords
{
    protected static string $resource = RequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
