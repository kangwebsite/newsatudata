<?php

namespace App\Filament\Resources\Datasets\Pages;

use App\Filament\Resources\Datasets\DatasetResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;

class ViewDataset extends ViewRecord
{
    protected static string $resource = DatasetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pratinjau_table')->label('Pratinjau TABLE')->icon(Heroicon::OutlinedTableCells)->modal()->modalSubmitAction(false)->modalCancelActionLabel('Tutup')
                ->modalContent(fn($record) => view(
                    'filament.actions.pratinjau-table',
                    ['dataset' => $record],
                ))->outlined()->hidden(fn($record) => !Storage::disk('public')->exists($record->file) || $record->typeData->id === 2),
            Action::make('pratinjau_grafik')->label('Pratinjau GRAFIK')->icon(Heroicon::OutlinedChartBar)->modal()->modalSubmitAction(false)->modalCancelActionLabel('Tutup')
                ->modalContent(fn($record) => view(
                    'filament.actions.pratinjau-chart',
                    ['dataset' => $record],
                ))->color('warning')->outlined()->hidden(fn($record) => !Storage::disk('public')->exists($record->file) || $record->typeData->id !== 3),
            Action::make('pratinjau_pdf')->label('Pratinjau PDF')->icon(Heroicon::OutlinedDocument)->modal()->modalSubmitAction(false)->modalCancelActionLabel('Tutup')
                ->modalContent(fn($record) => view(
                    'filament.actions.pratinjau-pdf',
                    ['dataset' => $record],
                ))->color('warning')
                ->modalWidth('5xl')
                ->slideOver(false)
                ->outlined()
                ->hidden(fn($record) => !Storage::disk('public')->exists($record->file) || $record->typeData->id !== 2),
            EditAction::make(),
        ];
    }

    public function downloadFile()
    {
        $record = $this->getRecord();

        if ($record && $record->file && Storage::disk('public')->exists($record->file)) {
            return Storage::disk('public')->download($record->file);
        }

        Notification::make()
            ->title('File tidak ditemukan')
            ->danger()
            ->send();
    }
}
