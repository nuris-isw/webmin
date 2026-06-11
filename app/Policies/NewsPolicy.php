<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;

class NewsPolicy
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

    public function view(User $user, News $news): bool
    {
        return $user->unit_id === $news->unit_id;
    }

    public function create(User $user): bool
    {
        return $user->unit_id !== null;
    }

    public function update(User $user, News $news): bool
    {
        return $user->unit_id === $news->unit_id;
    }

    public function delete(User $user, News $news): bool
    {
        return $user->unit_id === $news->unit_id;
    }
}
