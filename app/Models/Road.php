<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Road extends Model
{
    use Cachable;

    protected $guarded = ['id'];

    protected $casts = [
        'path_coordinates' => 'array',
    ];
}
