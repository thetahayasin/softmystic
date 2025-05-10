<?php

namespace App\Filament\Admin\Resources\RequirementResource\Pages;

use App\Filament\Admin\Resources\RequirementResource;
use Filament\Resources\Pages\EditRecord;

class EditRequirement extends EditRecord
{
    protected static string $resource = RequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
