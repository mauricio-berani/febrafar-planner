<?php

namespace App\Policies;

use App\Interfaces\PolicyInterface;
use App\Traits\IsUserAdministrator;

/**
 * This class defines the policies related to user actions.
 */
class UserPolicy extends ApiPolicy implements PolicyInterface
{
    use IsUserAdministrator;

    /**
     * Determine whether the user can view any models.
     */
    public function findAllMatches(): bool
    {
        return $this->isAdministrator($this->user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function findAll(): bool
    {
        return $this->isAdministrator($this->user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function findOne(): bool
    {
        return $this->isAdministrator($this->user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return $this->isAdministrator($this->user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(): bool
    {
        return $this->isAdministrator($this->user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(): bool
    {
        return $this->isAdministrator($this->user);
    }
}
