<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class PeriodeData extends Model
{
    use Cachable;

    protected $guarded = ['id'];

    public function datasets()
    {
        return $this->hasMany(Dataset::class);
    }
}
