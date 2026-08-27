<?php

namespace App\Livewire;

use App\Models\GeoType;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Session;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class GeoportalPage extends Component
{
    public array $allGeoTypes = [];
    public $mapType = 'default';
    public $polygon = true;
    public array $geoTypes = [];

    #[Session]
    public array $selected = [];

    public function mount()
    {
        $this->allGeoTypes = GeoType::with(['geoportals'])->get()->toArray();

        foreach ($this->allGeoTypes as $type) {
            $this->selected[$type['id']] = false; 
        }

        $this->geoTypes = $this->allGeoTypes;
    }

    public function updatedMapType()
    {
        $this->dispatch('change-basemap', $this->mapType);
    }

    public function updatedPolygon()
    {
        $this->dispatch('toggle-poly', $this->polygon);
    }

    public function updatedSelected()
    {
        $this->geoTypes = array_values(array_filter($this->allGeoTypes, function ($type) {
            return isset($this->selected[$type['id']]) && $this->selected[$type['id']] === true;
        }));

        $this->dispatch('markers-updated', $this->geoTypes);
    }

    public function clearFilters()
    {
        $this->polygon = false;
        $this->selected = [];
        $this->dispatch('toggle-poly', false);

        $this->geoTypes = $this->allGeoTypes;
        $this->dispatch('markers-updated', $this->geoTypes);
    }

    public function render()
    {
        return view('livewire.geoportal-page')->layout('layouts::app', [
            'SEOData' => new SEOData(
                title: 'Peta Geospasial',
                description: 'Eksplorasi data kewilayahan dan tematik Kabupaten Way Kanan dalam bentuk peta interaktif.'
            )
        ]);
    }
}
