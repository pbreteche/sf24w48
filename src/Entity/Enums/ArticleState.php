<?php

namespace App\Entity\Enums;

enum ArticleState: string
{
    case Published = 'published';
    case Draft = 'draft';
    case Trashed = 'trashed';
}
