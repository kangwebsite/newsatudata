<?php

namespace App\Filament\Resources\TypeData\Pages;

use App\Filament\Resources\TypeData\TypeDataResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTypeData extends ManageRecords
{
    protected static string $resource = TypeDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
