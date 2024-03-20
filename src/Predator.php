<?php

namespace Simulation;

use Simulation\PathFind\GraphOffsets;

class Predator extends Creature
{
    private int $attackPower = 5;

    public function getAttackPower(): int
    {
        return $this->attackPower;
    }

    public function findFoodResource(Map $map): array
    {
        return $map->getEntitiesByClass(Herbivore::class);
    }

    }

    public function __toString()
    {
        return "\u{1f408}";
    }

}