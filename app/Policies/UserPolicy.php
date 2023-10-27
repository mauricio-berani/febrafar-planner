<?php

namespace App\Policies;

use App\Enums\User\Roles;
use App\Interfaces\PolicyInterface;

/**
 * This class defines the policies related to user actions.
 */
class UserPolicy extends ApiPolicy implements PolicyInterface
{
    /**
     * Determine whether the user can view any models.
     *
     * @return bool
     */
    public function findAllMatches(): bool
    {
        return Roles::Administrator->value === $this->user->role;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return bool
     */
    public function findAll(): bool
    {
        return Roles::Administrator->value === $this->user->role;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return bool
     */
    public function findOne(): bool
    {
        return Roles::Administrator->value === $this->user->role;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return bool
     */
    public function create(): bool
    {
        return Roles::Administrator->value === $this->user->role;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return bool
     */
    public function update(): bool
    {
        return Roles::Administrator->value === $this->user->role;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return bool
     */
    public function delete(): bool
    {
        return Roles::Administrator->value === $this->user->role;
    }
}
