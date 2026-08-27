<?php

namespace App;

use BackedEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum Roles: string implements HasLabel, HasColor, HasIcon
{
    case Admin = 'admin';
    case BPS = 'bps';
    case User = 'user';
    
    public function getLabel(): string | Htmlable | null
    {    
        return match ($this) {
            self::Admin => 'Admin',
            self::BPS => 'BPS',
            self::User => 'User',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Admin => 'danger',
            self::BPS => 'info',
            self::User => 'success',
        };
    }

    public function getIcon(): string | BackedEnum | Htmlable | null
    {
        return match ($this) {
            self::Admin => Heroicon::OutlinedShieldCheck,
            self::BPS => Heroicon::OutlinedPresentationChartBar,
            self::User => Heroicon::OutlinedUser,
        };
    }
}
