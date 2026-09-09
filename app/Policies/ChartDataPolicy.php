<?php

namespace App\Policies;

use App\Models\ChartData;
use App\Models\User;

class ChartDataPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function view(User $user, ChartData $chartData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function update(User $user, ChartData $chartData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function delete(User $user, ChartData $chartData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function restore(User $user, ChartData $chartData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function forceDelete(User $user, ChartData $chartData): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }
}
