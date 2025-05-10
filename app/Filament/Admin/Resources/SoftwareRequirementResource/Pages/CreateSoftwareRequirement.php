<?php

namespace App\Filament\Admin\Resources\SoftwareRequirementResource\Pages;

use App\Filament\Admin\Resources\SoftwareRequirementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSoftwareRequirement extends CreateRecord
{
    protected static string $resource = SoftwareRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
