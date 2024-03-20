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

    public function locateMoveCoordinates(Map $map): ?Coordinates
    {
        $potentialMoves = $this->generateListPositionsFromCoordinates($map);
        $moves = $this->generateListCoordinateMoves($potentialMoves, $map);
        if (empty($moves)) {
            return $this->getCoordinates();
        }

        $move = array_rand($moves);
        return $moves[$move];
    }

    public function selectPredatorTarget(Targets $targets): ?Creature
    {
        if (!$targets->haveTargets()) {
            return null;
        }

        return $targets->calcDistanceBetweenTargets($this->getCoordinates())->setNearestTargetsFirst()->getTarget();
    }

    }

    public function __toString()
    {
        return "\u{1f408}";
    }

}