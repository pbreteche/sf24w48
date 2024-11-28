<?php

namespace App\Service;

use App\Model\DateRange;

class Calendar
{
    public function countWorkingDays(DateRange $dateRange): int
    {
        $count = 0;
        for ($d = $dateRange->getFrom(); $d <= $dateRange->getTo(); $d = $d->modify('+1 day')) {
            if ($this->isWorkingDay($d)) {
                ++$count;
            }
        }

        return $count;
    }

    private function isWorkingDay(\DateTimeImmutable $day): bool
    {
        if (5 < $day->format('N')) {
            return false;
        }

        $vernalEquinox = $day->modify('March 21');
        $easterDays = easter_days($day->format('Y'));
        $easterMonday = $vernalEquinox->modify('+'.($easterDays + 1).' days');
        $ascensionThursday = $vernalEquinox->modify('+'.($easterDays + 39).' days');
        $holidays = [
            '01-01', '05-01', '05-08', '07-14', '08-15', '11-01', '11-11', '12-25',
            $easterMonday->format('m-d'),
            $ascensionThursday->format('m-d'),
        ];

        if (in_array($day->format('m-d'), $holidays)) {
            return false;
        }

        return true;
    }
}
