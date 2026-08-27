<?php

namespace App\Livewire;

use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Tentang extends Component
{
    public function render()
    {
        return view('livewire.tentang')->layout('layouts::app', [
            'SEOData' => new SEOData(
                title: 'Apa itu Satu Data Way Kanan',
                description: 'Portal Satu Data Way Kanan merupakan portal resmi data terbuka (Open Data) Kabupaten Way Kanan. Portal ini lahir sebagai bentuk...'
            )
        ]);
    }
}
