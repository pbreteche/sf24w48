<?php

namespace App\Tests\Service;

use App\Model\DateRange;
use App\Service\Calendar;
use App\Service\ManagerDayOffCalculator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ManagerDayOffCalculatorTest extends KernelTestCase
{
    public function testCalculate()
    {
        self::bootKernel();

        $container = static::getContainer();

        $mock = $this->createMock(Calendar::class);

        $mock->expects($this->once())
            ->method('countWorkingDays')
            ->with($this->isInstanceOf(DateRange::class))
            ->willReturn(253);

        $container->set(Calendar::class, $mock);

        $managerDayOffCalculator = $container->get(ManagerDayOffCalculator::class);

        $result = $managerDayOffCalculator->calculate(2024);

        $this->assertEquals(10, $result);
    }
}
