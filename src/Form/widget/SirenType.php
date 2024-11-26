<?php

namespace App\Form\widget;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SirenType extends AbstractType
{
    public function getParent(): string
    {
        return TextType::class;
    }
}
