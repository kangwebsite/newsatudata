<?php

namespace App\Policies;

use App\Models\PeriodeData;
use App\Models\User;

class PeriodeDataPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function view(User $user, PeriodeData $periodeData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function update(User $user, PeriodeData $periodeData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function delete(User $user, PeriodeData $periodeData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function restore(User $user, PeriodeData $periodeData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function forceDelete(User $user, PeriodeData $periodeData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }
}
