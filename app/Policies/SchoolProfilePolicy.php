<?php

namespace App\Policies;

use App\Models\SchoolProfile;
use App\Models\User;

class SchoolProfilePolicy
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

    public function view(User $user, SchoolProfile $profile): bool
    {
        return $user->unit_id === $profile->unit_id;
    }

    public function update(User $user, SchoolProfile $profile): bool
    {
        return $user->unit_id === $profile->unit_id;
    }
}
