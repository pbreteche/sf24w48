<?php

namespace App\Service;

use App\Message\ContactMessage;
use App\Model\Contact;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class ContactDeliver
{
    public function __construct(
        private MessageBusInterface $bus,
    ) {
    }

    public function deliver(Contact $contact): void
    {
        $this->bus->dispatch(new ContactMessage($contact));
    }
}
