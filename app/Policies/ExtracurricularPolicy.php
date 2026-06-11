<?php

namespace App\Policies;

use App\Models\Extracurricular;
use App\Models\User;

class ExtracurricularPolicy
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

    public function view(User $user, Extracurricular $ekskul): bool
    {
        return $user->unit_id === $ekskul->unit_id;
    }

    public function create(User $user): bool
    {
        return $user->unit_id !== null;
    }

    public function update(User $user, Extracurricular $ekskul): bool
    {
        return $user->unit_id === $ekskul->unit_id;
    }

    public function delete(User $user, Extracurricular $ekskul): bool
    {
        return $user->unit_id === $ekskul->unit_id;
    }
}
