<?php

namespace App\Filament\Admin\Resources\SoftwareRequirementResource\Pages;

use App\Filament\Admin\Resources\SoftwareRequirementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSoftwareRequirements extends ListRecords
{
    protected static string $resource = SoftwareRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
