<?php

namespace Simulation\Actions;

use Simulation\Coordinates;
use Simulation\Map;

abstract class Actions
{
    abstract public function action(Map $map): void;

    protected function generateStartRandomPosition(Map $map): Coordinates
    {
        $x = random_int($map::MIN_COORDINATE, $map->getWidth());
        $y = random_int($map::MIN_COORDINATE, $map->getHeight());

        if ($map->haveEntityOnPosition(new Coordinates($x, $y))) {
            return $this->generateStartRandomPosition($map);
        }

        return new Coordinates($x, $y);
    }
}
