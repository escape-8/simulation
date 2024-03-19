<?php

namespace Simulation;


use RuntimeException;
use Simulation\PathFind\EnvironmentEvaluations;

class EntityFactory
{
    private EnvironmentEvaluations $environmentEvaluations;
    public function __construct(EnvironmentEvaluations $environmentEvaluations)
    {
        $this->environmentEvaluations = $environmentEvaluations;
    }
    public function create(string $class, $position): Entity
    {
        switch ($class) {
            case Grass::class:
                return new Grass();
            case Herbivore::class:
                return new Herbivore(
                    2,
                    10,
                    $position,
                    $this->environmentEvaluations->getHerbivoreEvaluations(),
                );
            case Predator::class:
                return new Predator(
                    1,
                    20,
                    $position,
                    $this->environmentEvaluations->getPredatorEvaluations(),
                );
            case Tree::class:
                return new Tree();
            case Rock::class:
                return new Rock();
            default:
                throw new RuntimeException("Unknown $class!");
        }
    }
}

