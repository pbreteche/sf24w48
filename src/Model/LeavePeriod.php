<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class LeavePeriod
{
    private ?Contact $contact = null;
    #[Assert\Valid]
    private ?DateRange $dateRange = null;

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): LeavePeriod
    {
        $this->contact = $contact;

        return $this;
    }

    public function getDateRange(): ?DateRange
    {
        return $this->dateRange;
    }

    public function setDateRange(?DateRange $dateRange): LeavePeriod
    {
        $this->dateRange = $dateRange;

        return $this;
    }
}
