<?php

namespace App\Policies;

use App\Models\Geoportal;
use App\Models\User;

class GeoportalPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function view(User $user, Geoportal $geoportal): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function update(User $user, Geoportal $geoportal): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function delete(User $user, Geoportal $geoportal): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function restore(User $user, Geoportal $geoportal): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function forceDelete(User $user, Geoportal $geoportal): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }
}
