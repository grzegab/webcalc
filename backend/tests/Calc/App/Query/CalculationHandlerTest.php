<?php

declare(strict_types=1);

namespace App\Tests\Calc\App\Query;

use App\Calc\App\Query\CalculationHandler;
use App\Calc\App\Query\CalculationQuery;
use App\Calc\DTO\Calculation;
use App\Calc\Enum\Operations;
use PHPUnit\Framework\TestCase;

class CalculationHandlerTest extends TestCase
{
    public function testDivisionByZero(): void
    {
        $handler = new CalculationHandler();
        $calculation = new Calculation();
        $calculation
            ->setNumberA(0)
            ->setNumberB(0)
            ->setOperation(Operations::DIVISION);
        $query = new CalculationQuery($calculation);
        $this->expectException('DivisionByZeroError');
        $result = $handler($query);

        self::assertSame(0, $result);
    }

    /**
     * @dataProvider operationsDataProvider
     */
    public function testOperations($expected, $numberA, $numberB, $operation)
    {
        $handler = new CalculationHandler();
        $calculation = new Calculation();
        $calculation
            ->setNumberA($numberA)
            ->setNumberB($numberB)
            ->setOperation($operation);
        $query = new CalculationQuery($calculation);
        $result = $handler($query);

        self::assertSame($expected, $result);
    }

    private function operationsDataProvider(): array
    {
        return [
            [0.0, 0, 0, Operations::ADDITION],
            [0.0, 0, 0, Operations::SUBTRACTION],
            [0.0, 0, 0, Operations::MULTIPLICATION],
            [0.0, 0, 1, Operations::DIVISION],
            [4.0, 1, 3, Operations::ADDITION],
            [13.0, 10, 3, Operations::ADDITION],
            [-8.8668, -12.21, 3.3432, Operations::ADDITION],
            [-34826206.5375, -32478923.21321234234, -2347283.324324234324, Operations::ADDITION],
            [-2108800.1, 29032.1, 2137832.2, Operations::SUBTRACTION],
            [2108800.1, -29032.1, -2137832.2, Operations::SUBTRACTION],
            [62065758213.62, -29032.1, -2137832.2, Operations::MULTIPLICATION],
            [-2.0, -1, 2, Operations::MULTIPLICATION],
            [0.0, -0, 0, Operations::MULTIPLICATION],
            [0.5, 1, 2, Operations::DIVISION],
            [0.0528, 11212.3242, 212312.23, Operations::DIVISION],
            [-152.7158, 32423423, -212312.23, Operations::DIVISION],
        ];
    }
}