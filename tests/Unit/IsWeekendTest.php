<?php

use App\Traits\IsWeekend;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class IsWeekendTest extends TestCase
{
    use DatabaseTransactions, IsWeekend;

    /**
     * Test if a given date is a weekend.
     *
     * @return void
     */
    public function testIsWeekend()
    {
        $weekendDate = '2023-10-28'; // Saturday
        $this->assertTrue($this->checkIfIsWeekend($weekendDate));

        $weekdayDate = '2023-10-25'; // Wednesday
        $this->assertFalse($this->checkIfIsWeekend($weekdayDate));
    }
}
