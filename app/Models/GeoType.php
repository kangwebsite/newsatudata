<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class GeoType extends Model
{
    use Cachable;

    protected $guarded = ['id'];

    public function geoportals()
    {
        return $this->hasMany(Geoportal::class);
    }
}
