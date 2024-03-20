<?php

namespace Simulation;

use Simulation\PathFind\GraphOffsets;

class Herbivore extends Creature
{
    public function findFoodResource(Map $map): array
    {
        return $map->getEntitiesByClass(Grass::class);
    }

    }

    public function __toString()
    {
        return "\u{1F401}";
    }
}