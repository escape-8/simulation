<?php

namespace Simulation;
class Coordinates
{
    private int $coordX;
    private int $coordY;

    /**
     * @param int $coordX
     * @param int $coordY
     */
    public function __construct(int $coordX, int $coordY)
    {
        $this->coordX = $coordX;
        $this->coordY = $coordY;
    }

    public function __toString()
    {
        return $this->coordX . ':' . $this->coordY;
    }

}