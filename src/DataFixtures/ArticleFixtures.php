<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Enums\ArticleState;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr');

        for ($i = 0; $i < 10; $i++) {
            $article = (new Article())
                ->setTitle($faker->sentence())
                ->setBody($faker->text(500))
                ->setState(ArticleState::Draft)
            ;
            $manager->persist($article);
        }
        for ($i = 0; $i < 3; $i++) {
            $article = (new Article())
                ->setTitle($faker->sentence())
                ->setBody($faker->text(500))
                ->setState(ArticleState::Published)
            ;
            $manager->persist($article);
        }

        $manager->flush();
    }
}
