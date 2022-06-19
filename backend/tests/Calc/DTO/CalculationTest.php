<?php

declare(strict_types=1);

namespace App\Tests\Calc\DTO;

use App\Calc\DTO\Calculation;
use App\Calc\Enum\Operations;
use PHPUnit\Framework\TestCase;

class CalculationTest extends TestCase
{
    public function testSimpleDto(): void
    {
        $firstNumber = 1.12234;
        $secondNumber = 2;

        $dto = new Calculation();
        $dto
            ->setNumberA($firstNumber)
            ->setNumberB($secondNumber)
            ->setOperation(Operations::ADDITION);

        self::assertSame($firstNumber, $dto->getNumberA());
        self::assertSame((float)$secondNumber, $dto->getNumberB());
        self::assertSame(Operations::ADDITION, $dto->getOperation());
    }
}
