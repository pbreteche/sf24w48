<?php

namespace App\Form\widget;

use App\Model\DateRange;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateRangeType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('from', DateType::class)
            ->add('to', DateType::class)
            ->setDataMapper($this)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DateRange::class,
            'empty_data' => null,
        ]);
    }

    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        if (is_null($viewData)) {
            return;
        }

        if (!$viewData instanceof DateRange) {
            throw new UnexpectedTypeException($viewData, DateRange::class);
        }

        $forms['from']->setData($viewData->getFrom());
        $forms['to']->setData($viewData->getTo());
    }

    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = iterator_to_array($forms);

        $from = $forms['from']->getData();
        $to =$forms['to']->getData();

        if (is_null($from) || is_null($to)) {
            return;
        }

        $viewData = new DateRange(
            $forms['from']->getData(),
            $forms['to']->getData(),
        );
    }
}
