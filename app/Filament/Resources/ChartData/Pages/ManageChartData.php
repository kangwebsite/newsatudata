<?php

namespace App\Filament\Resources\ChartData\Pages;

use App\Filament\Resources\ChartData\ChartDataResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageChartData extends ManageRecords
{
    protected static string $resource = ChartDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
