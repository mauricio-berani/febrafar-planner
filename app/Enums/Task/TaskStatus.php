<?php

namespace App\Enums\Task;

/**
 * This enum class represents the status a task type can have within the application.
 */
enum TaskStatus: string
{
    case Pendding = 'pendding';
    case Done = 'done';
}
