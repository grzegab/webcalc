<?php

declare(strict_types=1);

namespace App\Calc\Enum;

enum Operations: string
{
    case ADDITION = 'addition';
    case SUBTRACTION = 'subtraction';
    case MULTIPLICATION = 'multiplication';
    case DIVISION = 'division';
}
