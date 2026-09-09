<?php

namespace App\Policies;

use App\Models\DatasetLog;
use App\Models\User;

class DatasetLogPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function view(User $user, DatasetLog $datasetLog): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function update(User $user, DatasetLog $datasetLog): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function delete(User $user, DatasetLog $datasetLog): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function restore(User $user, DatasetLog $datasetLog): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function forceDelete(User $user, DatasetLog $datasetLog): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }
}
