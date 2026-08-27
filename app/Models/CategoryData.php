<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\Attributes\Sluggable;

#[Sluggable(from: 'name', to: 'slug')]
class CategoryData extends Model
{
    use Cachable;
    
    protected $guarded = ['id'];

    public function datasets()
    {
        return $this->hasMany(Dataset::class);
    }

    public function getIconAttribute()
    {
        $icons = [
            'Pendidikan' => 'ph ph-graduation-cap',
            'Kesehatan' => 'ph ph-heartbeat',
            'Infrastruktur' => 'ph ph-bridge',
            'Ekonomi' => 'ph ph-chart-line-up',
            'Sosial' => 'ph ph-users-three',
            'Pemerintahan' => 'ph ph-bank'
        ];

        return $icons[$this->name] ?? 'fas fa-folder';
    }

    public function getColorAttribute()
    {
        $colors = [
            'Pendidikan' => '#6b46c1',
            'Kesehatan' => '#e53e3e',
            'Infrastruktur' => '#3182ce',
            'Ekonomi' => '#dd6b20',
            'Sosial' => '#ed8936',
            'Pemerintahan' => '#38a169'
        ];

        return $colors[$this->name] ?? '#a0aec0';
    }
}
