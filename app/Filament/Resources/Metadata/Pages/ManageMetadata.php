<?php

namespace App\Filament\Resources\Metadata\Pages;

use App\Filament\Resources\Metadata\MetadataResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMetadata extends ManageRecords
{
    protected static string $resource = MetadataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
