<?php

namespace App\Livewire;

use App\Models\ChartData;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Visualisasi extends Component
{
    #[Computed]
    public function chartData()
    {
        return ChartData::latest()->get('*');
    }

    public function render()
    {
        return view('livewire.visualisasi');
    }
}
