<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Geoportal extends Model
{
    use Cachable;

    protected $guarded = ['id'];

    public function geoType()
    {
        return $this->belongsTo(GeoType::class);
    }
}
