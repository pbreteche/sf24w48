<?php

namespace App\Form;

use App\Form\widget\SirenType;
use App\Model\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', options: ['required' => false])
            ->add('firstName', options: ['required' => false])
            ->add('email', options: ['required' => false])
            ->add('phone')
            ->add('birthdate')
            ->add('siren', SirenType::class, [
                'mapped' => false,
                'help' => 'Mettre le siren de la société mère.',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
