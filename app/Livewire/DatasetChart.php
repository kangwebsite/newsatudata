<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;

class DatasetChart extends ChartWidget
{
    public $dataset;
    protected ?string $heading = 'Grafik';
    protected ?string $maxHeight = '150rem';
    protected string $color = 'info';

    protected function getData(): array
    {
        $labels = [];
        $dataValues = [];

        if ($this->dataset && $this->dataset->file) {
            $path = Storage::path($this->dataset->file);
            
            if (file_exists($path)) {
                $spreadsheet = IOFactory::load($path);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                foreach ($rows as $index => $row) {
                    if ($index === 0) {
                        continue;
                    }

                    if (!empty($row[1])) {
                        $labels[] = (string) $row[1];
                        $dataValues[] = isset($row[2]) ? (float) str_replace(',', '', $row[2]) : 0;
                    }
                }
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => $dataValues,
                    'backgroundColor' => '#047480',
                    'borderColor' => '#047480',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}