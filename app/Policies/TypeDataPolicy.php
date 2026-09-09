<?php

namespace App\Policies;

use App\Models\TypeData;
use App\Models\User;

class TypeDataPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function view(User $user, TypeData $typeData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function update(User $user, TypeData $typeData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function delete(User $user, TypeData $typeData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function restore(User $user, TypeData $typeData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function forceDelete(User $user, TypeData $typeData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }
}
