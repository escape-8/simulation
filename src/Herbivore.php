<?php

namespace Simulation;

use Simulation\PathFind\GraphOffsets;

class Herbivore extends Creature
{
    public function findFoodResource(Map $map): array
    {
        return $map->getEntitiesByClass(Grass::class);
    }

    public function selectHerbivoreTarget(Targets $targets, Map $map): ?Grass
    {
        if (!$targets->haveTargets()) {
            return null;
        }

        while($targets->haveTargets()) {
            $nearestTarget = $targets->getTarget();

            if ($this->getCoordinates()->isCoordinateNeighbor($nearestTarget->getCoordinates())) {
                return $nearestTarget;
            }

            if (!$this->hasPredatorNearest($map, $nearestTarget->getCoordinates())) {
                return $nearestTarget;
            }
        }

        return null;
    }

    }

    public function __toString()
    {
        return "\u{1F401}";
    }
}