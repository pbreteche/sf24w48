<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Enums\ArticleState;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/article', defaults: ['_format' => 'json'])]
class ArticleController extends AbstractController
{
    #[Route('/', methods: 'GET')]
    public function export(
        ArticleRepository $articleRepository,
        TranslatorInterface $translator
    ): Response {
        $articles = $articleRepository->findBy([], limit: 10);

        return $this->json($articles, context: [
            AbstractNormalizer::GROUPS => ['teaser'],
            AbstractNormalizer::CALLBACKS => [
                'state' => fn (ArticleState $state) => $translator->trans(sprintf('article.state.%s', $state->value))
            ],
        ]);
    }
    #[Route('/', methods: 'POST')]
    public function new(
        Request $request,
        EntityManagerInterface $manager,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
    ): Response {
        $article = $serializer->deserialize($request->getContent(), Article::class, 'json');
        $violations = $validator->validate($article);
        if (0 >= count($violations)) {
            $manager->persist($article);
            $manager->flush();
            return $this->json(['state' => 'ok'], Response::HTTP_CREATED);
        }

        return $this->json($violations, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route('/{id}', methods: 'GET')]
    public function show(
        Article $article,
    ): Response {
        return $this->json($article);
    }

    #[Route('/{id}', methods: 'PUT')]
    public function update(
        Article $article,
        Request $request,
        EntityManagerInterface $manager,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
    ): Response {
        $serializer->deserialize($request->getContent(), Article::class, 'json', [
            AbstractNormalizer::OBJECT_TO_POPULATE => $article,
        ]);
        $violations = $validator->validate($article);
        if (0 >= count($violations)) {
            $manager->persist($article);
            $manager->flush();
            return $this->json(['state' => 'ok'], Response::HTTP_CREATED);
        }

        return $this->json($violations, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
