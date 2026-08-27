<?php

use App\Models\Geoportal;
use App\Models\GeoType;
use Livewire\Attributes\Session;
use Livewire\Component;

new class extends Component
{
    public array $allGeoTypes = [];
    
    public array $geoTypes = [];
    
    #[Session]
    public array $selected = [];

    public $total = 0;

    public function mount()
    {
        $this->allGeoTypes = GeoType::with(['geoportals'])->get()->toArray();

        foreach ($this->allGeoTypes as $type) {
            $this->selected[$type['id']] = false; 
        }

        $this->total = Geoportal::count('id');

        $this->geoTypes = $this->allGeoTypes;
    }

    public function updatedSelected()
    {
        $this->geoTypes = array_values(array_filter($this->allGeoTypes, function ($type) {
            return isset($this->selected[$type['id']]) && $this->selected[$type['id']] === true;
        }));

        $this->dispatch('markers-updated');
    }

    public function toGeoportal()
    {
        return $this->redirect('/geospasial', navigate: true);
    }
};