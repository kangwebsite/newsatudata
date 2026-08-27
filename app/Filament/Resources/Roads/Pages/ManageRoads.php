<?php

namespace App\Filament\Resources\Roads\Pages;

use App\Filament\Resources\Roads\RoadResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageRoads extends ManageRecords
{
    protected static string $resource = RoadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
