<?php

namespace App\Filament\Admin\Resources\SoftwareResource\Pages;

use App\Filament\Admin\Resources\SoftwareResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSoftware extends ListRecords
{
    protected static string $resource = SoftwareResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
