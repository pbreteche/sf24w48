<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class LocaleUpdatedEvent extends Event
{
    public function __construct(
        private readonly string $locale,
    ) {
    }

    public function getLocale(): string
    {
        return $this->locale;
    }
}
