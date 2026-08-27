<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\Attributes\Sluggable;

#[Sluggable(from: 'title', to: 'slug')]
class Post extends Model
{
    use Cachable;

    protected $guarded = ['id'];

    protected $casts = [
        'tags' => 'array'
    ];

    public function getExcerptAttribute()
    {
        return Str::words(strip_tags($this->body), 15, '...');
    }
}
