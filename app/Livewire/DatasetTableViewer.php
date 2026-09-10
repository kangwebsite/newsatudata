<?php

namespace App\Livewire;

use Filament\Widgets\Widget;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;

class DatasetTableViewer extends Widget
{
    protected static ?string $heading = 'Pratinjau Data (Tabel)';
    protected string $view = 'livewire.dataset-table-viewer';

    public $dataset;

    public function getViewData(): array
    {
        $rows = [];
        if ($this->dataset && $this->dataset->file) {
            $path = Storage::path($this->dataset->file);
            if (file_exists($path)) {
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                if (in_array($ext, ['xlsx', 'xls', 'csv'])) {
                    $spreadsheet = IOFactory::load($path);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $rows = $worksheet->toArray();
                }
            }
        }

        return [
            'rows' => $rows,
        ];
    }
}
