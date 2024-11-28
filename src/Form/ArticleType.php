<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Enums\ArticleState;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('body')
            ->add('state', EnumType::class, [
                'class' => ArticleState::class,
                'placeholder' => 'select a state',
            ])
            ->addEventListener(FormEvents::SUBMIT, function (SubmitEvent $event) {
                $article = $event->getData();
                if (ArticleState::Published === $article->getState()) {
                    $event->getForm()->add('notifyUsers', CheckboxType::class, [
                        'mapped' => false,
                        'required' => false,
                    ]);
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
