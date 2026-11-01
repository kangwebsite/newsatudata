<?php

namespace App\Filament\Resources\Roads\Pages;

use App\Filament\Resources\Roads\RoadResource;
use App\Models\Road;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\EmbeddedTable;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ManageRoads extends ManageRecords
{
    protected static string $resource = RoadResource::class;

    /**
     * State form tambah jalan yang ditampilkan di atas tabel.
     *
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        parent::mount();

        $this->roadForm->fill();
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Tambah jalan baru')
                ->description('Isi koordinat titik A dan titik B (latitude & longitude), pilih warna dan kategori jalan, lalu tekan Simpan.')
                ->schema([
                    $this->getFormContentComponent(),
                ]),

            EmbeddedTable::make(),
        ]);
    }

    public function getFormContentComponent(): Form
    {
        return Form::make([
            EmbeddedSchema::make('roadForm'),
        ])
            ->id('roadForm')
            ->livewireSubmitHandler('createRoad')
            ->footer([
                Actions::make([
                    Action::make('createRoad')
                        ->label('Simpan')
                        ->icon('heroicon-m-plus')
                        ->submit('createRoad'),
                ]),
            ]);
    }

    public function defaultRoadForm(Schema $schema): Schema
    {
        return $schema
            ->model(Road::class)
            ->operation('create')
            ->statePath('data');
    }

    public function roadForm(Schema $schema): Schema
    {
        return RoadResource::form($schema);
    }

    public function createRoad(): void
    {
        $data = $this->data ?? [];

        // path_coordinates dari Textarea (JSON string), atau susun dari lat_a/lng_a/lat_b/lng_b.
        $pathCoords = $data['path_coordinates'] ?? null;
        if (! empty($pathCoords)) {
            $raw = is_string($pathCoords)
                ? json_decode($pathCoords, true)
                : $pathCoords;

            $coordinates = is_array($raw) && count($raw) >= 2
                ? array_map(fn ($c) => [(float) $c[0], (float) $c[1]], $raw)
                : [
                    [(float) ($data['lat_a'] ?? 0), (float) ($data['lng_a'] ?? 0)],
                    [(float) ($data['lat_b'] ?? 0), (float) ($data['lng_b'] ?? 0)],
                ];
        } else {
            $coordinates = [
                [(float) ($data['lat_a'] ?? 0), (float) ($data['lng_a'] ?? 0)],
                [(float) ($data['lat_b'] ?? 0), (float) ($data['lng_b'] ?? 0)],
            ];
        }

        Road::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'warna' => $data['warna'],
            'path_coordinates' => $coordinates,
        ]);

        $this->roadForm->fill();

        $this->resetTable();

        Notification::make()
            ->title('Jalan berhasil disimpan')
            ->success()
            ->send();
    }
}