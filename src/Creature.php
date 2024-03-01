<?php

namespace Simulation;

abstract class Creature extends Entity
{
    protected int $speed;
    protected int $healthPoints;

    public function __construct(int $speed, int $healthPoints, Coordinates $coordinates)
    {
        $this->speed = $speed;
        $this->healthPoints = $healthPoints;
        $this->coordinates = $coordinates;
    }

    abstract public function makeMovie();
}