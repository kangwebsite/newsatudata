<?php

namespace App\Filament\Resources\GeoTypes\Pages;

use App\Filament\Resources\GeoTypes\GeoTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageGeoTypes extends ManageRecords
{
    protected static string $resource = GeoTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
