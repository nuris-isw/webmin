<?php

namespace App\Policies;

use App\Models\SpmbSetting;
use App\Models\User;

class SpmbSettingPolicy
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

    public function view(User $user, SpmbSetting $setting): bool
    {
        return $user->unit_id === $setting->unit_id;
    }

    public function update(User $user, SpmbSetting $setting): bool
    {
        return $user->unit_id === $setting->unit_id;
    }
}
