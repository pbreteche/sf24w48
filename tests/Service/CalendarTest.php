<?php

namespace App\Tests\Service;

use App\Model\DateRange;
use App\Service\Calendar;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{

    /**
     * @dataProvider workingDaysProvider
     */
    public function testCountWorkingDays($from, $to, $expected)
    {
        $calendar = new Calendar();
        $result = $calendar->countWorkingDays(new DateRange(
            new \DateTimeImmutable($from),
            new \DateTimeImmutable($to),
        ));
        $this->assertEquals($expected, $result);
    }

    public function testInvalidDateRange()
    {
        $calendar = new Calendar();
        $this->expectException(\InvalidArgumentException::class);
        $calendar->countWorkingDays(new DateRange(
            new \DateTimeImmutable('2024-01-10'),
            new \DateTimeImmutable('2024-01-01'),
        ));
    }

    public function workingDaysProvider(): array
    {
        return [
            ['2024-05-01', '2024-05-31', 20],
            ['2024-07-08', '2024-07-14', 5],
        ];
    }
}
