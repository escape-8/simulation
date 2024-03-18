<?php

namespace Simulation;

class Coordinates
{
    private int $coordX;
    private int $coordY;

    public function __construct(int $coordX, int $coordY)
    {
        $this->coordX = $coordX;
        $this->coordY = $coordY;
    }

    public function shiftCoordinates(ShiftCoordinate $shift): Coordinates
    {
        $x = $this->getCoordX() + $shift->getMoveX();
        $y = $this->getCoordY() + $shift->getMoveY();
        return new Coordinates($x, $y);
    }

    public function __toString()
    {
        return $this->coordX . ':' . $this->coordY;
    }

}