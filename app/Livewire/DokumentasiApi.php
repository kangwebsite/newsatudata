<?php

namespace App\Livewire;

use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class DokumentasiApi extends Component
{
    public function render()
    {
        return view('livewire.dokumentasi-api')->layout('layouts::app', [
            'SEOData' => new SEOData(
                title: 'Dokumentasi API',
                description: 'Integrasikan data dari portal Satu Data Way Kanan langsung ke dalam aplikasi atau analisis Anda melalui RESTful API. Gratis, terbuka, dan mudah digunakan.'
            )
        ]);
    }
}
