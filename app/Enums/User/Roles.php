<?php

namespace App\Enums\User;

/**
 * This enum class represents the roles a user can have within the application.W
 */
enum Roles: string
{
    case User = 'user';
    case Administrator = 'administrator';
}
