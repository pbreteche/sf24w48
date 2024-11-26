<?php

namespace App\Model;

enum ContactType: string
{
    case Person = 'person';
    case Company = 'company';
}
