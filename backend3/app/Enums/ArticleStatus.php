<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ArticleStatus extends Enum
{
    const Published =   0;
    const Revoked =   1;
    const Draft = 2;
}
