<?php

declare(strict_types=1);

namespace App\Calc\App\Query;

use App\Calc\Enum\Operations;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CalculationHandler implements MessageHandlerInterface
{
    public function __invoke(CalculationQuery $query): float
    {
        $result = match($query->calculation->getOperation()) {
            Operations::ADDITION => $query->calculation->getNumberA() + $query->calculation->getNumberB(),
            Operations::SUBTRACTION => $query->calculation->getNumberA() - $query->calculation->getNumberB(),
            Operations::MULTIPLICATION => $query->calculation->getNumberA() * $query->calculation->getNumberB(),
            Operations::DIVISION => $query->calculation->getNumberA() / $query->calculation->getNumberB(),
        };

        return round($result, 4, PHP_ROUND_HALF_EVEN);
    }
}
