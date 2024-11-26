<?php

namespace App\Form\widget;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class SirenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addViewTransformer(new CallbackTransformer(
                fn ($siren) => substr($siren, 0, 3).' '.substr($siren, 3, 3).' '.substr($siren, 6, 3).' '.substr($siren, 9),
                fn ($siren) => preg_replace('/[^0-9]+/', '', $siren),
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [
                new Regex('/^[0-9]{14}$/', message: 'Siren should have exactly 14 digits.'),
            ],
        ]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}
