<?php

namespace Simulation;

use Simulation\PathFind\Graph;
use Simulation\PathFind\PathFind;

abstract class Creature extends Entity
{
    protected int $speed;
    protected int $healthPoints;
    protected array $environmentEvaluations;
    protected ?Coordinates $coordinatesForSimpleMove;

    public function __construct(int $speed, int $healthPoints, Coordinates $coordinates)
    {
        $this->speed = $speed;
        $this->healthPoints = $healthPoints;
        $this->coordinates = $coordinates;
    }

    abstract public function makeMovie();
}