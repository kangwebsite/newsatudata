<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class ChartData extends Model
{
    use Cachable;
    
    protected $guarded = ['id'];
}
