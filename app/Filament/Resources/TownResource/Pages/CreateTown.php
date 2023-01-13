<?php

namespace App\Filament\Resources\TownResource\Pages;

use App\Filament\Resources\TownResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTown extends CreateRecord
{
    protected static string $resource = TownResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // TODO: Change the autogenerated stub
    }
}
