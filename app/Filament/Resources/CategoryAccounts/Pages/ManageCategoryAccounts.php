<?php

namespace App\Filament\Resources\CategoryAccounts\Pages;

use App\Filament\Resources\CategoryAccounts\CategoryAccountResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCategoryAccounts extends ManageRecords
{
    protected static string $resource = CategoryAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
