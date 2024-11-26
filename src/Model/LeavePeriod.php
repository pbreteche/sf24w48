<?php

namespace App\Model;

class LeavePeriod
{
    private ?Contact $contact = null;
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
