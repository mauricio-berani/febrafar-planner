<?php

namespace App\Traits;

use App\Enums\User\Roles;
use App\Models\User;

trait IsUserAdministrator
{
    /**
     * Get pagination details.
     */
    public function isAdministrator(User $user): bool
    {
        return Roles::Administrator->value === $user->role;
    }
}
