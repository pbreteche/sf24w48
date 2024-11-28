<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Signature
{
    public int $height;
    public int $width;

    public function mount(int $height = 150, int $width = 300): void
    {
        $this->height = max($height, 50);
        $this->width = max($width, 50);
    }
}
