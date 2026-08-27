<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    use Cachable;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'produsen_data', 'id');
    }
}
