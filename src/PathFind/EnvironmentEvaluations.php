<?php

namespace Simulation\PathFind;

use Simulation\Coordinates;
use Simulation\Grass;
use Simulation\Herbivore;
use Simulation\Predator;
use Simulation\Rock;
use Simulation\Tree;

class EnvironmentEvaluations
{
    protected const BASE_EVALUATIONS = [
        Rock::class => [
            'cost' => 10,
            'haveField' => false,
        ],
        Tree::class => [
            'cost' => 10,
            'haveField' => false,
        ],
        Coordinates::class => [
            'cost' => 2,
            'haveField' => false,
        ],
    ];

    public function mergeEvaluations(array $base, array $additional): array
    {
        return [...$base, ...$additional];
    }
    public function getPredatorEvaluations(): array
    {
        return $this->mergeEvaluations(self::BASE_EVALUATIONS,
            [
                Herbivore::class => [
                    'cost' => 1,
                    'haveField' => false,
                ],
                Predator::class => [
                    'cost' => 3,
                    'haveField' => false,
                ],
                Grass::class => [
                    'cost' => 3,
                    'haveField' => false,
                ],
            ]
        );
    }

    public function getHerbivoreEvaluations(): array
    {
        return $this->mergeEvaluations(self::BASE_EVALUATIONS,
            [
                Herbivore::class => [
                    'cost' => 3,
                    'haveField' => false,
                ],
                Predator::class => [
                    'cost' => 9,
                    'haveField' => true,
                    'fieldCost' => 9,
                    ],
                Grass::class => [
                    'cost' => 1,
                    'haveField' => false,
                ],
            ]
        );
    }
}
