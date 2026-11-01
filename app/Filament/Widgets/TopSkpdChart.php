<?php

namespace App\Filament\Widgets;

use App\Services\DashboardMetrics;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Str;

class TopSkpdChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 1;

    protected ?string $heading = 'SKPD Paling Produktif';

    protected ?string $description = '10 instansi dengan jumlah dataset terbanyak';

    protected ?string $maxHeight = '360px';

    protected function getData(): array
    {
        // Satu query agregat (join) — tanpa hidrasi model Eloquent.
        $rows = DashboardMetrics::topSkpd(10);

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Dataset',
                    'data' => array_column($rows, 'total'),
                    'backgroundColor' => '#0f766e',
                    'borderRadius' => 6,
                ],
            ],
            'labels' => array_map(
                fn (array $row): string => Str::of($row['name'])->title()->limit(32)->toString(),
                $rows,
            ),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
                'y' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }
}
