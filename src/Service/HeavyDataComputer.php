<?php

namespace App\Service;

class HeavyDataComputer
{
    public function compute(): array
    {
        usleep(10);

        return [1, 2, 3];
    }
}
