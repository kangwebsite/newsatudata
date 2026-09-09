<?php

namespace App\Policies;

use App\Models\CategoryAccount;
use App\Models\User;

class CategoryAccountPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function view(User $user, CategoryAccount $categoryAccount): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function update(User $user, CategoryAccount $categoryAccount): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function delete(User $user, CategoryAccount $categoryAccount): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function restore(User $user, CategoryAccount $categoryAccount): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function forceDelete(User $user, CategoryAccount $categoryAccount): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }
}
