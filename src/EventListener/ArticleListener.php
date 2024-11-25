<?php

namespace App\EventListener;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

/**
 * Entity listeners target one Entity class.
 */
#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Article::class)]
class ArticleListener
{
    public function preUpdate(Article $article, PreUpdateEventArgs $args)
    {
        // do something
    }
}