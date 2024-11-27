<?php

namespace App\MessageHandler;

use App\Message\ContactMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ContactMessageHandler
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(ContactMessage $message): void
    {
        $this->logger->info('Contact message has been processed', ['message' => $message]);
    }
}
