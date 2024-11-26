<?php

namespace App\Form;

use App\Form\widget\SirenType;
use App\Model\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Symfony\Component\String\u;

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
            ->addEventListener(FormEvents::SUBMIT, self::onSubmit(...))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }

    /**
     * Alter user submitted data after normalization.
     */
    public function onSubmit(SubmitEvent $event): void
    {
        /** @var Contact $data */
        $data = $event->getData();
        $form = $event->getForm();

        $data->setLastName(u($form->get('lastName')->getData())->title(allWords: true));
        $data->setFirstName(u($form->get('firstName')->getData())->title(allWords: true));
    }
}
