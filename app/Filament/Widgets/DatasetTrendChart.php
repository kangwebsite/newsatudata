<?php

namespace App\Filament\Widgets;

use App\Services\DashboardMetrics;
use Filament\Widgets\ChartWidget;

class DatasetTrendChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected ?string $heading = 'Tren Unggahan Dataset';

    protected ?string $description = 'Jumlah dataset yang diunggah per bulan (12 bulan terakhir)';

    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $trend = DashboardMetrics::monthlyDatasetCounts(12);

        return [
            'datasets' => [
                [
                    'label' => 'Dataset',
                    'data' => array_column($trend, 'total'),
                    'borderColor' => '#0f766e',
                    'backgroundColor' => 'rgba(15, 118, 110, 0.12)',
                    'pointBackgroundColor' => '#0f766e',
                    'pointBorderColor' => '#0f766e',
                    'pointRadius' => 3,
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
            'labels' => array_column($trend, 'label'),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
            'elements' => [
                'line' => [
                    'borderWidth' => 3,
                ],
            ],
        ];
    }
}
