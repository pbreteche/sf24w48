<?php

namespace App\Tests\Service;

use App\Service\Calendar;
use App\Service\ManagerDayOffCalculator;
use PHPUnit\Framework\TestCase;

class ManagerDayOffCalculatorTest extends TestCase
{
    private ManagerDayOffCalculator $managerDayOffCalculator;

    public function setUp(): void
    {
        $stub = $this->createStub(Calendar::class);

        // Configure the stub.
        $stub->method('countWorkingDays')
            ->willReturn(253);

        $this->managerDayOffCalculator = new ManagerDayOffCalculator($stub);
    }

    public function testCalculate()
    {
        $result = $this->managerDayOffCalculator->calculate(2024);

        $this->assertEquals(10, $result);
    }
}
