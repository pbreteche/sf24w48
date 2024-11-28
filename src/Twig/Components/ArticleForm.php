<?php

namespace App\Twig\Components;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ArticleForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?Article $initialData = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ArticleType::class, $this->initialData);
    }

    #[LiveAction]
    public function save(
        EntityManagerInterface $manager,
    ): Response {
        // Declare form is submitted and validate data
        // Throw an UnprocessableEntityHttpException if data is invalid
        // Exception is handled by LiveController
        $this->submitForm();
        // Form is always valid here!
        $manager->persist($this->getForm()->getData());
        $manager->flush();
        $this->addFlash('success', 'Article saved');

        return $this->redirectToRoute('app_default_index');
    }
}
