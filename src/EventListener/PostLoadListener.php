<?php

namespace App\EventListener;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Events;

/**
 * Lifecycle listeners are called for any entity
 */
#[AsDoctrineListener(event: Events::postLoad, priority: 500, connection: 'default')]
class PostLoadListener
{
    public function postLoad(PostLoadEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getObject();
        if (!$entity instanceof Article) {
            // do something
        }
    }
}
