<?php

namespace App\Twig\Components;

use App\Model\DateRange;
use App\Service\Calendar;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class WorkingDays
{
    public DateRange $range;

    public function __construct(
        private readonly Calendar $calendar,
    ) {
    }

    public function count(): int
    {
        return $this->calendar->countWorkingDays($this->range);
    }
}
