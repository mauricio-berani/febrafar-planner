<?php

namespace App\Traits;

use App\Models\User;
use App\Enums\User\Roles;

trait IsUserAdministrator
{
    /**
     * Get pagination details.
     *
     * @return bool
     */
    public function isAdministrator(User $user): bool
    {
        return Roles::Administrator->value === $user->role;
    }
}
