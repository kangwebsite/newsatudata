<?php

namespace App\Policies;

use App\Models\Metadata;
use App\Models\User;

class MetadataPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function view(User $user, Metadata $metadata): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function update(User $user, Metadata $metadata): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function delete(User $user, Metadata $metadata): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function restore(User $user, Metadata $metadata): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function forceDelete(User $user, Metadata $metadata): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }
}
