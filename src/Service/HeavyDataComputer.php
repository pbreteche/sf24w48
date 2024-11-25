<?php

namespace App\Service;

class HeavyDataComputer
{
    public function compute(): array
    {
        sleep(10);

        return [1, 2, 3];
    }
}
