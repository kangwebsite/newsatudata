<?php

namespace App\Livewire;

use App\Models\GeoType;
use Livewire\Attributes\Computed;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class GeoportalPage extends Component
{
    public $mapType = 'default';
    public $polygon = true;
    public array $selected = [];

    public function updatedMapType()
    {
        $this->dispatch('change-basemap', $this->mapType);
    }

    public function updatedPolygon()
    {
        $this->dispatch('toggle-poly', $this->polygon);
    }

    public function clearFilters()
    {
        $this->polygon = false;
        $this->selected = [];
        $this->dispatch('toggle-poly', false);
    }

    #[Computed]
    public function geoTypes()
    {
        return GeoType::with(['geoportals'])->get();
    }

    public function render()
    {
        return view('livewire.geoportal-page')->layout('layouts::app', [
            'SEOData' => new SEOData(
                title: 'Peta Geospasial Full',
                description: 'Eksplorasi data kewilayahan dan tematik Kabupaten Way Kanan dalam bentuk peta interaktif.'
            )
        ]);
    }
}
