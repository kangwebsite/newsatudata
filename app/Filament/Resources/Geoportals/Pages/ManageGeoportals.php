<?php

namespace App\Filament\Resources\Geoportals\Pages;

use App\Filament\Resources\Geoportals\GeoportalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageGeoportals extends ManageRecords
{
    protected static string $resource = GeoportalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
