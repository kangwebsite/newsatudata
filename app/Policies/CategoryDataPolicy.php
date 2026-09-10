<?php

namespace App\Policies;

use App\Models\CategoryData;
use App\Models\User;

class CategoryDataPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function view(User $user, CategoryData $categoryData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function update(User $user, CategoryData $categoryData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function delete(User $user, CategoryData $categoryData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function restore(User $user, CategoryData $categoryData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function forceDelete(User $user, CategoryData $categoryData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }
}
