<?php

namespace App\Filament\Imports;

use App\Models\Dataset;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class DatasetImporter extends Importer
{
    protected static ?string $model = Dataset::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('description')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('category_data_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('periode_data_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('type_data_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('status')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('file'),
            ImportColumn::make('upload_by')
                ->ignoreBlankState()
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer', 'exists:users,id']),
            ImportColumn::make('created_at'),
            ImportColumn::make('updated_at'),
        ];
    }

    public function resolveRecord(): Dataset
    {
        return Dataset::firstOrNew([
            'slug' => $this->data['slug'],
        ]);
    }

    protected function afterCreate(): void
    {
        $this->record->logs()->create([
            'text' => $this->record->uploadBy->name . " Membuat dataset",
            'created_at' => $this->data['created_at'],
            'updated_at' => $this->data['updated_at'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your dataset import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
