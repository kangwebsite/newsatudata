<?php

namespace App\Livewire;

use App\Models\Metadata;
use Livewire\Attributes\Computed;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class MetadataPage extends Component
{
    public $tahun = '';
    public $search = '';

    #[Computed]
    public function metadatas()
    {
        return Metadata::with(['user'])
            ->when($this->tahun, fn($query) => $query->where('tahun', $this->tahun))
            ->when($this->search, fn($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.metadata-page')->layout('layouts::app', [
            'SEOData' => new SEOData(
                title: 'Daftar Kegiatan',
                description: 'Kumpulan informasi metadata (data tentang data) dari berbagai kegiatan penyelenggaraan statistik sektoral oleh OPD di lingkungan Pemerintah Kabupaten Way Kanan.'
            )
        ]);
    }
}
