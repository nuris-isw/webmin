<?php

namespace App\Policies;

use App\Models\Gallery;
use App\Models\User;

class GalleryPolicy
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

    public function view(User $user, Gallery $gallery): bool
    {
        return $user->unit_id === $gallery->unit_id;
    }

    public function create(User $user): bool
    {
        return $user->unit_id !== null;
    }

    public function update(User $user, Gallery $gallery): bool
    {
        return $user->unit_id === $gallery->unit_id;
    }

    public function delete(User $user, Gallery $gallery): bool
    {
        return $user->unit_id === $gallery->unit_id;
    }
}
