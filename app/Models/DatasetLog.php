<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class DatasetLog extends Model
{
    use Cachable;

    protected $guarded = ['id'];

    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }
}
