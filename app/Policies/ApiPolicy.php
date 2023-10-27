<?php

namespace App\Policies;

use App\Models\User;

/**
 * This class represents a base policy from which other policy classes can extend.
 */
class ApiPolicy
{
    /**
     * The authenticated user.
     *
     * @var User
     */
    protected $user;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        $this->user = User::find(auth()->user()->id);
    }
}
