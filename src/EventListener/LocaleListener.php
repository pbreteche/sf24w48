<?php

namespace App\EventListener;

use App\Event\LocaleUpdatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class LocaleListener
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    #[AsEventListener(event: KernelEvents::REQUEST, priority: 32)]
    public function onKernelRequest(RequestEvent $event): void
    {
       $request = $event->getRequest();
       $locale = $request->getPreferredLanguage(['fr', 'en_US', 'es', 'de']);
       if ($locale) {
           $request->setLocale($locale);
       }
    }

    #[AsEventListener(event: LocaleUpdatedEvent::class)]
    public function onLocaleUpdated(LocaleUpdatedEvent $event): void
    {
        $this->logger->info(sprintf('Locale has been updated to %s', $event->getLocale()));
    }
}
