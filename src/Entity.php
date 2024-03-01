<?php

namespace Simulation;
abstract class Entity
{
    protected Coordinates $coordinates;

    public function setCoordinates(Coordinates $coordinates): void
    {
        $this->coordinates = $coordinates;
    }
    abstract public function __toString();
}
