<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;

class ContactPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function view(User $user, Contact $contact): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function update(User $user, Contact $contact): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function delete(User $user, Contact $contact): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function restore(User $user, Contact $contact): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }

    public function forceDelete(User $user, Contact $contact): bool
    {
        return in_array($user->role?->value ?? $user->role, ['admin']);
    }
}
