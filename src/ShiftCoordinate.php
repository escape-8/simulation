<?php

namespace Simulation;

class ShiftCoordinate
{
    private int $moveX;
    private int $moveY;

    public function __construct($moveX, $moveY)
    {
        $this->moveX = $moveX;
        $this->moveY = $moveY;
    }

    public function getMoveX(): int
    {
        return $this->moveX;
    }

    public function getMoveY(): int
    {
        return $this->moveY;
    }
}
