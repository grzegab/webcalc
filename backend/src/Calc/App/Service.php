<?php

declare(strict_types=1);

namespace App\Calc\App;

use App\Calc\App\Query\CalculationQuery;

use App\Calc\DTO\Calculation;
use App\Calc\Enum\Operations;
use App\Calc\Exceptions\NumberException;
use App\Calc\Exceptions\OperationException;
use App\Core\App\AbstractService;
use Exception;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class Service extends AbstractService
{
    public function __construct(public readonly MessageBusInterface $messageBus)
    {
    }

    #[OA\Response(response: '200', description: 'Calculation result ok')]
    #[OA\Response(response: '422', description: 'Calculation input is wrong')]
    #[OA\Parameter(
        name: 'First number',
        description: 'First provided number',
        in: 'query',
        schema: new OA\Schema(type: 'float')
    )]
    #[OA\Parameter(
        name: 'Second number',
        description: 'Second provided number',
        in: 'query',
        schema: new OA\Schema(type: 'float')
    )]
    #[OA\Parameter(
        name: 'Operation type',
        description: 'One of available operations: addition, subtraction, multiply, division',
        in: 'query',
        schema: new OA\Schema(type: Operations::class)
    )]
    #[Route('/make', name: 'calculation', methods: 'POST')]
    public function makeCalculation(Request $request): Response
    {
        try {
            $numberA = $request->get('numberA');
            if (! is_numeric($numberA)) {
                throw new NumberException('Expected number in variable number A');
            }

            $numberB = $request->get('numberB');
            if (! is_numeric($numberB)) {
                throw new NumberException('Expected number in variable number B');
            }

            $operationEnum = Operations::tryFrom($request->get('operation'));
            if ($operationEnum === null) {
                throw new OperationException('Wrong operation');
            }
        } catch (NumberException|OperationException $e) {
            return new JsonResponse($e->getMessage(), 422);
        }

        $calcDTO = new Calculation();
        $calcDTO
            ->setNumberA((float)$numberA)
            ->setNumberB((float)$numberB)
            ->setOperation($operationEnum);

        $query = new CalculationQuery($calcDTO);

        return new JsonResponse($this->handleMessage($query));
    }
}
