<?php

namespace App\Form\Guesser;

use App\Form\widget\DateRangeType;
use App\Model\DateRange;
use Symfony\Component\Form\FormTypeGuesserInterface;
use Symfony\Component\Form\Guess;

class DateRangeTypeGuesser implements FormTypeGuesserInterface
{
    /**
     * @inheritDoc
     */
    public function guessType(string $class, string $property): ?Guess\TypeGuess
    {
        try {
            $refProperty = new \ReflectionProperty($class, $property);
        } catch (\ReflectionException) {
            return null;
        }

        $type = $refProperty->getType();
        if ($type instanceof \ReflectionNamedType) {
            if (DateRange::class === $type->getName()) {
                return new Guess\TypeGuess(DateRangeType::class, [
                    'empty_data' => null,
                ], Guess\TypeGuess::VERY_HIGH_CONFIDENCE);
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function guessRequired(string $class, string $property): ?Guess\ValueGuess
    {
        try {
            $refProperty = new \ReflectionProperty($class, $property);
        } catch (\ReflectionException) {
            return null;
        }

        return new Guess\ValueGuess(!$refProperty->getType()->allowsNull(), Guess\ValueGuess::HIGH_CONFIDENCE);
    }

    /**
     * @inheritDoc
     */
    public function guessMaxLength(string $class, string $property): ?Guess\ValueGuess
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function guessPattern(string $class, string $property): ?Guess\ValueGuess
    {
        return null;
    }
}