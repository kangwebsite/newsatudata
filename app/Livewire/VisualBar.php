<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Storage;

class VisualBar extends ChartWidget
{
    public $chart;

    public function getHeading(): string
    {
        return $this->chart->title;
    }

    protected function getData(): array
    {
        $grafik = $this->chartData($this->chart->file);

        return [
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => $grafik['data'],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    'borderWidth' => 1,
                    'borderRadius' => 10,
                ],
            ],
            'labels' => $grafik['label'],
        ];
    }

    public function chartData($path)
    {
        $fullPath = storage_path('app/public/' . $path);
        $rows = array_map('str_getcsv', file($fullPath));

        $labels = [];
        $data = [];
        foreach ($rows as $row){
            $labels[] = $row[0];
            $data[] = $row[1];
        }
        return [
            'label' => $labels,
            'data' => $data
        ];
    }

    protected function getType(): string
    {
        return $this->chart->type_chart ?? 'bar';
    }
}
