<?php

namespace App\Tests\Service;

use App\Service\ManagerDayOffCalculator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ManagerDayOffCalculatorTest extends KernelTestCase
{
    public function testCalculate()
    {
        self::bootKernel();

        $container = static::getContainer();
        $managerDayOffCalculator = $container->get(ManagerDayOffCalculator::class);

        $result = $managerDayOffCalculator->calculate(2024);

        $this->assertEquals(10, $result);
    }
}
