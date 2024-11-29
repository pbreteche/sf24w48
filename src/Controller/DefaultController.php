<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\HeavyDataComputer;
use App\Service\ManagerDayOffCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class DefaultController extends AbstractController
{
    #[Route('/')]
    #[Cache(expires: '+1 hour', public: true)]
    public function index(
        CacheInterface $cache,
        TagAwareCacheInterface $myDedicatedCache,
        HeavyDataComputer $dataComputer,
        Request $request,
        ManagerDayOffCalculator $managerDayOffCalculator,
    ): Response {
        $heavyComputedData = $cache->get('heavy-computed-data', function (ItemInterface $item) use ($dataComputer) {
            $item->expiresAfter(3600);

            return $dataComputer->compute();
        });

        if ($request->query->has('force')) {
            $myDedicatedCache->delete('another-computed-data');
        }

        $myDedicatedCache->get('another-computed-data', function (ItemInterface $item) {
            $item->tag('tag-1');

           return true;
        });

        $myDedicatedCache->invalidateTags(['tag-1', 'tag-2']);

        return $this->render('default/index.html.twig');
    }
}
