<?php

namespace App\Form;

use App\EventListener\ContactListener;
use App\Form\widget\SirenType;
use App\Model\Contact;
use App\Model\ContactType as ModelContactType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Symfony\Component\String\u;

class ContactType extends AbstractType
{
    public function __construct(
        private readonly ContactListener $contactListener,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', options: ['required' => false, 'priority' => 20])
            ->add('firstName', options: ['required' => false, 'priority' => 20])
            ->add('email', options: ['required' => false, 'priority' => 20])
            ->add('phone')
            ->add('birthdate')
            ->add('siren', SirenType::class, [
                'mapped' => false,
                'help' => 'Mettre le siren de la société mère.',
                'required' => false,
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (PreSetDataEvent $event) {
                /** @var Contact $data */
                $data = $event->getData();
                if ($data && ModelContactType::Company === $data->getType()) {
                    $form = $event->getForm();
                    $form->add('company', SirenType::class, [
                        'mapped' => false,
                        'priority' => 10,
                    ]);
                }
            })
            ->addEventListener(FormEvents::SUBMIT, self::onSubmit(...))
            ->addEventListener(FormEvents::POST_SUBMIT, $this->contactListener->postSubmit(...))
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
        $data = $event->getData();
        if (!$data instanceof Contact) {
            return;
        }
        $form = $event->getForm();

        $data->setLastName(u($form->get('lastName')->getData())->title(allWords: true));
        $data->setFirstName(u($form->get('firstName')->getData())->title(allWords: true));
    }
}
