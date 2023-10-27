<?php

namespace App\Traits;

use Carbon\Carbon;

trait IsWeekend
{
    /**
     * Get pagination details.
     */
    public function checkIfIsWeekend(string $date): bool
    {
        return Carbon::parse($date)->isWeekend();
    }
}
