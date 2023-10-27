<?php

namespace App\Traits;

use Carbon\Carbon;

trait IsWeekend
{
    /**
     * Get pagination details.
     *
     * @return bool
     */
    public function checkIfIsWeekend(string $date): bool
    {
        return Carbon::parse($date)->isWeekend();
    }
}
