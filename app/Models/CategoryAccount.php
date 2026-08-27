<?php

namespace App\Models;

use App\CategoryAccounts;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\Attributes\Sluggable;

#[Sluggable(from: 'name', to: 'slug')]
class CategoryAccount extends Model
{
    use Cachable;

    protected $guarded = ['id'];

    protected $casts = [
        // 'name' => CategoryAccounts::class
    ];
}
