<?php

namespace App\Filament\Widgets;

use App\Services\DashboardMetrics;
use Filament\Widgets\ChartWidget;

class DatasetTypeChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 1;

    protected ?string $heading = 'Komposisi Tipe Dataset';

    protected ?string $description = 'Persentase dataset berdasarkan tipe data';

    protected ?string $maxHeight = '360px';

    protected function getData(): array
    {
        // Satu query agregat (join) — tanpa hidrasi model Eloquent.
        $types = DashboardMetrics::typeDistribution();

        return [
            'datasets' => [
                [
                    'label' => 'Dataset',
                    'data' => array_column($types, 'total'),
                    'backgroundColor' => array_column($types, 'color'),
                    'borderWidth' => 2,
                ],
            ],
            'labels' => array_map(
                fn (array $type): string => sprintf('%s (%d%%)', $type['name'], $type['percentage']),
                $types,
            ),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'cutout' => '62%',
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
