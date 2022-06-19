<?php

declare(strict_types=1);

namespace App\Calc\App\Query;

use App\Calc\DTO\Calculation;

class CalculationQuery
{
    public function __construct(
        public readonly Calculation $calculation,
    )
    {
    }
}
