<?php

namespace App\Filament\Admin\Resources\SoftwareResource\Pages;

use App\Filament\Admin\Resources\SoftwareResource;
use Filament\Resources\Pages\CreateRecord;


class CreateSoftware extends CreateRecord
{
    protected static string $resource = SoftwareResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {


        $data['downloads'] = 0;
        $data['user_id'] = auth()->id();
        return $data;
    }

    // protected function getRedirectUrl(): string
    // {
    //     return $this->getResource()::getUrl('index');
    // }



    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
