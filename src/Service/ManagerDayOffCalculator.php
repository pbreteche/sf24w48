<?php

namespace App\Service;

use App\Model\DateRange;

class ManagerDayOffCalculator
{
    const DAYS_TO_WORK = 218;
    const PAID_LEAVES = 25;

    public function __construct(
        private readonly Calendar $calendar,
    ) {
    }

    public function calculate(int $year): int
    {
        $from = new \DateTimeImmutable($year.'-01-01');
        $to = $from->modify('31 december this year');
        $range = new DateRange($from, $to);
        $workingDays = $this->calendar->countWorkingDays($range);

        return $workingDays - static::DAYS_TO_WORK - static::PAID_LEAVES;
    }
}
