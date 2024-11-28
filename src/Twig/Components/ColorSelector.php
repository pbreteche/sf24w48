<?php

namespace App\Twig\Components;

use App\Service\HTMLNamedColors;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ColorSelector
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $colorSearch = '';

    public function __construct(
        private readonly HTMLNamedColors $namedColors
    ) {
    }

    /**
     * @return string[]
     */
    public function getColorList(): array
    {
        if (!$this->colorSearch) {
            return [];
        }

        return $this->namedColors->getColors($this->colorSearch);
    }
}
