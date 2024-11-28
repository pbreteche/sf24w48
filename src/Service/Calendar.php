<?php

namespace App\Service;

use App\Model\DateRange;

class Calendar
{
    public function countWorkingDays(DateRange $dateRange): int
    {
        $count = 0;
        for ($d = $dateRange->getFrom(); $d <= $dateRange->getTo(); $d = $d->modify('+1 day')) {
            if (6 > $d->format('N')) {
                ++$count;
            }
        }

        return $count;
    }
}
