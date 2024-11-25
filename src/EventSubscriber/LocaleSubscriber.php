<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * 1. Créer une méthode de contrôleur afin d'enregistrer en session
 *      la valeur d'une locale.
 * 2. Créer un subscriber qui va définir la locale courante par celle de la session
 *      si elle existe.
 */
class LocaleSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $session = $request->getSession();
        if ($session->has('locale')) {
            $request->setLocale($session->get('locale'));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 24],
        ];
    }
}
