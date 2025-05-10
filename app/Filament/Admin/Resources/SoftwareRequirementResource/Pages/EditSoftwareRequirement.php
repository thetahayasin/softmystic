<?php

namespace App\Filament\Admin\Resources\SoftwareRequirementResource\Pages;

use App\Filament\Admin\Resources\SoftwareRequirementResource;
use Filament\Resources\Pages\EditRecord;

class EditSoftwareRequirement extends EditRecord
{
    protected static string $resource = SoftwareRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
