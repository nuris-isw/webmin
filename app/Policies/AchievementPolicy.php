<?php

namespace App\Policies;

use App\Models\Achievement;
use App\Models\User;

class AchievementPolicy
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
        return $user->unit_id !== null;
    }

    public function view(User $user, Achievement $achievement): bool
    {
        return $user->unit_id === $achievement->unit_id;
    }

    public function create(User $user): bool
    {
        return $user->unit_id !== null;
    }

    public function update(User $user, Achievement $achievement): bool
    {
        return $user->unit_id === $achievement->unit_id;
    }

    public function delete(User $user, Achievement $achievement): bool
    {
        return $user->unit_id === $achievement->unit_id;
    }
}
