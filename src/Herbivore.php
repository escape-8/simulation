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

    public function locateMoveCoordinates(Map $map): Coordinates
    {
        if ($this->getCoordinateForSimpleMove() &&
            !$this->hasPredatorNearest($map, $this->getCoordinateForSimpleMove()) &&
            !$this->getCoordinateForSimpleMove()->equals($this->getCoordinates())) {
            return $this->getCoordinateForSimpleMove();
        }

        $potentialMoves = $this->generateListPositionsFromCoordinates($map);
        $moves = $this->generateListCoordinateMoves($potentialMoves, $map);
        $targets = new Targets($map, $moves);

        $farTargets = $targets->calcDistanceBetweenTargets($this->getCoordinates())->shuffleTargets()->setFarTargetsFirst();

        while($farTargets->haveTargets()) {
            $farTarget = $farTargets->getTarget();
            if (!$this->hasPredatorNearest($map, $farTarget)) {
                $this->setCoordinateForSimpleMove($farTarget);
                return $farTarget;
            }
        }
        return $this->getCoordinates();
    }

    }

    public function __toString()
    {
        return "\u{1F401}";
    }
}