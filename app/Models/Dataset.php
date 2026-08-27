<?php

namespace App\Models;

use App\DatasetStatuses;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\Attributes\Sluggable;

#[Sluggable(from: 'name', to: 'slug')]
class Dataset extends Model
{
    use Cachable;

    protected $guarded = ['id'];

    protected $casts = ['logs' => 'array', 'status' => DatasetStatuses::class];

    public function getShortDescriptionAttribute()
    {
        $description = $this->attributes['description'];

        if (strlen($description) > 100) {
            return substr($description, 0, 100) . '...';
        }
        return $description;
    }

    public function categoryData()
    {
        return $this->belongsTo(CategoryData::class);
    }

    public function periodeData()
    {
        return $this->belongsTo(PeriodeData::class);
    }

    public function typeData()
    {
        return $this->belongsTo(TypeData::class);
    }

    public function uploadBy()
    {
        return $this->belongsTo(User::class, 'upload_by', 'id');
    }

    public function logs()
    {
        return $this->hasMany(DatasetLog::class);
    }
}
