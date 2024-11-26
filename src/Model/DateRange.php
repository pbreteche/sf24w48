<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

readonly class DateRange
{
    public function __construct(
        #[Assert\GreaterThanOrEqual('tomorrow', groups: ['planning'])]
        private \DateTimeImmutable $from,
        #[Assert\GreaterThan(propertyPath: 'from')]
        private \DateTimeImmutable $to
    ) {
    }

    public function getFrom(): \DateTimeImmutable
    {
        return $this->from;
    }

    public function getTo(): \DateTimeImmutable
    {
        return $this->to;
    }
}
