<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\HeavyDataComputer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class DefaultController extends AbstractController
{
    #[Route('/')]
    public function index(
        CacheInterface $cache,
        HeavyDataComputer $dataComputer,
    ): Response {
        $heavyComputedData = $cache->get('heavy-computed-data', function (ItemInterface $item) use ($dataComputer) {
            $item->expiresAfter(3600);

            return $dataComputer->compute();
        });

        dump($heavyComputedData);

        return $this->render('default/index.html.twig');
    }
}
