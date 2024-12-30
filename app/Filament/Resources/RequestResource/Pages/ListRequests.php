<?php

namespace App\Filament\Resources\RequestResource\Pages;

use App\Filament\Resources\RequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRequests extends ListRecords
{
    protected static string $resource = RequestResource::class;

    public function getHeading(): string
    {
        return 'Requisições BGP';
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
