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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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

    #[Route('/http')]
    public function demoHttpClient(
        HttpClientInterface $client,
        DecoderInterface $serializer,
        CacheInterface $cache,
        UrlGeneratorInterface $urlGenerator,
    ): Response {
        $composteurs = $cache->get('composteurs-quartier-nantes', function (ItemInterface $item) use ($serializer, $client) {
            $item->expiresAfter(1);
            $apiEndPoint = 'https://data.nantesmetropole.fr/api/explore/v2.1/catalog/datasets/512042839_composteurs-quartier-nantes-metropole/records';
            $apiResponse = $client->request('GET', $apiEndPoint, [
                'query' => [
                    'limit' => 5,
                    'where' => 'lieu = "Nantes"',
                ],
            ]);

            return $serializer->decode($apiResponse->getContent(), JsonEncoder::FORMAT);
        });

//        $response = $client->request('GET', $urlGenerator->generate(
//            'app_article_show',
//            ['id' => 10],
//            UrlGeneratorInterface::ABSOLUTE_URL,
//        ));
//
//        dump($response->getContent());


        return $this->render('default/http.html.twig', [
            'composteurs' => $composteurs['results'],
        ]);
    }
}
