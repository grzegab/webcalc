<?php

declare(strict_types=1);

namespace App\Calc\DTO;

use App\Calc\Enum\Operations;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class Calculation
{
    #[OA\Property(property: "NumberA", description: "First number", type: "float")]
    #[Groups(groups: ['default', 'create'])]
    #[Assert\NotBlank(groups: ['default', 'create'])]
    private float $numberA;

    #[OA\Property(property: 'NumberB', description: 'Second number', type: 'float')]
    #[Groups(groups: ['default', 'create'])]
    #[Assert\NotBlank(groups: ['default', 'create'])]
    private float $numberB;

    #[OA\Property(property: 'Operation', description: 'Calc operation', type: Operations::class)]
    #[Groups(groups: ['default', 'create'])]
    #[Assert\NotBlank(groups: ['default', 'create'])]
    private Operations $operation;

    public function setNumberA(float $numberA): Calculation
    {
        $this->numberA = $numberA;
        return $this;
    }

    public function getNumberA(): float
    {
        return $this->numberA;
    }

    public function setNumberB(float $numberB): Calculation
    {
        $this->numberB = $numberB;
        return $this;
    }

    public function getNumberB(): float
    {
        return $this->numberB;
    }

    public function setOperation(Operations $operation): Calculation
    {
        $this->operation = $operation;
        return $this;
    }

    public function getOperation(): Operations
    {
        return $this->operation;
    }
}