<?php

namespace App\Policies;

use App\Models\Major;
use App\Models\User;

class MajorPolicy
{
    /**
     * Superadmin bypass.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isSuperadmin()) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        // Must belong to SMK
        return $user->unit && $user->unit->isSmk();
    }

    public function view(User $user, Major $major): bool
    {
        return $user->unit_id === $major->unit_id;
    }

    public function create(User $user): bool
    {
        return $user->unit && $user->unit->isSmk();
    }

    public function update(User $user, Major $major): bool
    {
        return $user->unit_id === $major->unit_id;
    }

    public function delete(User $user, Major $major): bool
    {
        return $user->unit_id === $major->unit_id;
    }
}
