<?php

namespace App\Livewire;

use App\Models\Metadata;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class MetadataDetailPage extends Component
{
    public Metadata $metadata;

    public function download()
    {
        return Storage::download($this->metadata->file);
    }

    public function back()
    {
        return $this->redirect('/metadata', navigate: true);
    }

    public function render()
    {
        return view('livewire.metadata-detail-page')->layout('layouts::app', [
            'SEOData' => new SEOData(
                title: $this->metadata->name,
                description: $this->metadata->sektor_kegiatan
            )
        ]);
    }
}
