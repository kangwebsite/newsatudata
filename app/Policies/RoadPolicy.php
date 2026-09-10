<?php

namespace App\Policies;

use App\Models\Road;
use App\Models\User;

class RoadPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function view(User $user, Road $road): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function update(User $user, Road $road): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function delete(User $user, Road $road): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function restore(User $user, Road $road): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function forceDelete(User $user, Road $road): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }
}
