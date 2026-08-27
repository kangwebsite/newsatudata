<?php

namespace App\Filament\Resources\CategoryData\Pages;

use App\Filament\Resources\CategoryData\CategoryDataResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCategoryData extends ManageRecords
{
    protected static string $resource = CategoryDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
