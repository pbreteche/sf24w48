<?php

namespace App\Message;

use App\Model\Contact;

readonly class ContactMessage
{
    public function __construct(
        private Contact $contact,
    ) {
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }
}
