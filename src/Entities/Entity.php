<?php

namespace Simulation\Entities;

use Simulation\Coordinates\Coordinates;

abstract class Entity
{
    protected Coordinates $coordinates;

    public function setCoordinates(Coordinates $coordinates): void
    {
        $this->coordinates = $coordinates;
    }

    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

    abstract public function __toString();
}
