<?php

namespace App\Filament\Widgets;

use App\Services\DashboardMetrics;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $metrics = DashboardMetrics::summary();

        $trend = DashboardMetrics::monthlyDatasetCounts(12);

        return [
            Stat::make('Total Dataset', number_format($metrics['datasets']))
                ->description(number_format($metrics['approved']) . ' dataset disetujui')
                ->descriptionIcon(Heroicon::OutlinedCheckBadge)
                ->color('primary')
                ->chart(array_column($trend, 'total'))
                ->chartColor('primary'),

            Stat::make('SKPD Terdaftar', number_format($metrics['skpd']))
                ->description('Instansi aktif di portal')
                ->descriptionIcon(Heroicon::OutlinedBuildingOffice2)
                ->color('success'),

            Stat::make('Total Pengguna', number_format($metrics['users']))
                ->description(number_format($metrics['bps']) . ' BPS · ' . number_format($metrics['admin']) . ' admin')
                ->descriptionIcon(Heroicon::OutlinedUsers)
                ->color('info'),

            Stat::make('Berita Terpublish', number_format($metrics['posts']))
                ->description('Publikasi berita & artikel')
                ->descriptionIcon(Heroicon::OutlinedNewspaper)
                ->color('warning'),
        ];
    }
}
