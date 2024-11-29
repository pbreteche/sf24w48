<?php

namespace App\Tests\Service;

use App\Model\DateRange;
use App\Service\Calendar;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{

    public function testCountWorkingDays()
    {
        $calendar = new Calendar();
        $result = $calendar->countWorkingDays(new DateRange(
            new \DateTimeImmutable('2024-05-01'),
            new \DateTimeImmutable('2024-05-31')
        ));
        $this->assertEquals(20, $result);

        $result = $calendar->countWorkingDays(new DateRange(
            new \DateTimeImmutable('2024-07-08'),
            new \DateTimeImmutable('2024-07-14')
        ));
        $this->assertEquals(5, $result);
    }
}
