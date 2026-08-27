<?php

namespace App;

use BackedEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum CategoryAccounts: string implements HasLabel, HasColor, HasIcon
{
    case SKPD = 'SKPD';
    case NonSKPD = 'Non SKPD';
    
    public function getLabel(): string | Htmlable | null
    {    
        return $this->name;
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::SKPD => 'warning',
            self::NonSKPD => 'info',
        };
    }

    public function getIcon(): string | BackedEnum | Htmlable | null
    {
        return match ($this) {
            self::SKPD => Heroicon::OutlinedBuildingLibrary,
            self::NonSKPD => Heroicon::OutlinedBuildingOffice2,
        };
    }
}
