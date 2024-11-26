<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\Form\Event\PostSubmitEvent;

readonly class ContactListener
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function postSubmit(PostSubmitEvent $event): void
    {
        $this->logger->info('A contact form was submitted.', ['form' => $event->getForm()]);
    }
}
