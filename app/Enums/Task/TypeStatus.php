<?php

namespace App\Enums\Task;

/**
 * This enum class represents the status a task type can have within the application.
 */
enum TypeStatus: string
{
    case Visible = 'visible';
    case Hidden = 'hidden';
}
