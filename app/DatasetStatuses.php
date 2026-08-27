<?php

namespace App;

use BackedEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum DatasetStatuses: string implements HasLabel, HasColor, HasIcon
{
    case Draft = 'draft';
    case Reviewed = 'reviewed';
    case Verified = 'verified';
    case Approved = 'approved';
    case Published = 'published';
    case Rejected = 'rejected';
    
    public function getLabel(): string | Htmlable | null
    {    
        return $this->name;
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Reviewed => 'warning',
            self::Verified => 'info',
            self::Approved => 'success',
            self::Published => 'primary',
            self::Rejected => 'danger',
        };
    }

    public function getIcon(): string | BackedEnum | Htmlable | null
    {
        return match ($this) {
            self::Draft => 'heroicon-o-document-text',
            self::Reviewed => 'heroicon-o-magnifying-glass',
            self::Verified => 'heroicon-o-check-badge',
            self::Approved => 'heroicon-o-check-circle',
            self::Published => 'heroicon-o-globe-alt',
            self::Rejected => 'heroicon-o-x-circle',
        };
    }
}