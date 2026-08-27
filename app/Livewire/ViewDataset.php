<?php

namespace App\Livewire;

use App\Models\Dataset;
use App\Services\FileServices;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class ViewDataset extends Component
{
    public $dataset;
    public $file = [];
    public $excelStyles = '';
    public $excelTable = '';
    public $iconFile = '';

    public function mount(Dataset $dataset)
    {
        $this->dataset = $dataset;
        $this->file = [
            'filename' => basename($dataset->file),
            'filesize' => FileServices::getSize($dataset->file),
            'extension' => strtoupper(pathinfo($dataset->file, PATHINFO_EXTENSION))
        ];

        $this->iconFile = FileServices::getIcon($this->file['extension']);
    }

    public function downloadFile()
    {
        return Storage::download($this->dataset->file);
    }

    public function render()
    {
        return view('livewire.view-dataset')->layout('layouts::app', [
            'SEOData' => new SEOData(
                title: $this->dataset->name,
                description: $this->dataset->description
            )
        ]);
    }
}