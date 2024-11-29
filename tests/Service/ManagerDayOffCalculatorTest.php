<?php

namespace App\Tests\Service;

use App\Model\DateRange;
use App\Service\Calendar;
use App\Service\ManagerDayOffCalculator;
use PHPUnit\Framework\TestCase;

class ManagerDayOffCalculatorTest extends TestCase
{
    private ManagerDayOffCalculator $managerDayOffCalculator;

    public function setUp(): void
    {
        $mock = $this->createMock(Calendar::class);

        $mock->expects($this->once())
            ->method('countWorkingDays')
            ->with($this->isInstanceOf(DateRange::class))
            ->willReturn(253);

        $this->managerDayOffCalculator = new ManagerDayOffCalculator($mock);
    }

    public function testCalculate()
    {
        $result = $this->managerDayOffCalculator->calculate(2024);

        $this->assertEquals(10, $result);
    }
}
