<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;

class ContactPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function view(User $user, Contact $contact): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function update(User $user, Contact $contact): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function delete(User $user, Contact $contact): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function restore(User $user, Contact $contact): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }

    public function forceDelete(User $user, Contact $contact): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin', 'bps']);
    }
}
