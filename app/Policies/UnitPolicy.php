<?php

namespace App\Policies;

use App\Models\Unit;
use App\Models\User;

class UnitPolicy
{
    /**
     * Superadmin bypass for all actions.
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
        return false;
    }

    public function view(User $user, Unit $unit): bool
    {
        return $user->unit_id === $unit->id;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Unit $unit): bool
    {
        return false;
    }

    public function delete(User $user, Unit $unit): bool
    {
        return false;
    }
}
