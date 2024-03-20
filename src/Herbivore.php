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

    public function eatGrass(Grass $grass): Coordinates
    {
        return $grass->getCoordinates();
    }

    public function makeMovie(Map $map): Coordinates
    {
        $foodResource = $this->selectHerbivoreTarget($this->locateFoodResources($map), $map);
        if (!$foodResource) {
            $targetCoordinates = $this->locateMoveCoordinates($map);
        } else {
            $targetCoordinates = $foodResource->getCoordinates();
            if ($this->getCoordinates()->isCoordinateNeighbor($targetCoordinates)) {
                return $this->eatGrass($foodResource);
            }
        }
        $graph = $map->toGraph($this->getEnvironmentEvaluations(), new GraphOffsets(GraphOffsets::HERBIVORE_GRAPH_OFFSET));

        return $this->getStepCoordinate($map, $targetCoordinates, $graph);
    }

    public function generateListPositionsFromCoordinates(Map $map): array
    {
        $listOfPositions = [];
        for ($offset = 1, $maxOffset = $this->getSpeed(); $offset <= $maxOffset; $offset++) {
            if ($offset > 1) {
                $offsets = [
                    $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate(0, $offset)),
                    $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate($offset - 1, $offset - 1)),
                    $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate($offset, 0)),
                    $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate($offset - 1, -$offset + 1)),
                    $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate(0, -$offset)),
                    $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate(-$offset + 1, -$offset + 1)),
                    $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate(-$offset, 0)),
                    $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate(-$offset + 1, $offset - 1)),
                ];
            } else {
                $offsets = [
                    $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate(0, $offset)),
                    $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate($offset, 0)),
                    $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate(0, -$offset)),
                    $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate(-$offset, 0)),
                ];
            }
            $listOfPositions = [...$listOfPositions, ...$offsets];
        }

        return array_unique($listOfPositions);
    }

    public function __toString()
    {
        return "\u{1F401}";
    }
}