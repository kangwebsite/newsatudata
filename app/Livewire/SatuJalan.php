<?php

namespace App\Livewire;

use App\Models\Road;
use Livewire\Component;

class SatuJalan extends Component
{
    public array $roads = [];
    public ?string $selectedRoad = null;
    public string $mapType = 'default';

    public function mount()
    {
        $this->roads = Road::select('id', 'name', 'type', 'warna', 'path_coordinates')
            ->whereNotNull('path_coordinates')
            ->orderBy('name')
            ->get()
            ->map(function ($road) {
                $coords = is_string($road->path_coordinates)
                    ? json_decode($road->path_coordinates, true)
                    : $road->path_coordinates;

                return [
                    'id' => $road->id,
                    'name' => $road->name,
                    'type' => $road->type,
                    'warna' => $road->warna,
                    'coordinates' => is_array($coords) ? $coords : [],
                ];
            })
            ->toArray();

        // Select first road by default
        if (! empty($this->roads)) {
            $this->selectedRoad = $this->roads[0]['id'];
        }
    }

    public function selectRoad(string $roadId): void
    {
        $this->selectedRoad = $roadId;
    }

    public function render()
    {
        return view('livewire.satu-jalan');
    }
}
