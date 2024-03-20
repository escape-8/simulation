<?php

namespace Simulation\Entities;

use Simulation\Coordinates\ShiftCoordinate;
use Simulation\Coordinates\Coordinates;
use Simulation\Map\Map;
use Simulation\PathFind\GraphOffsets;
use Simulation\Utility\Targets;

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

        return $targets->getTarget();
    }

    public function makeMovie(Map $map): Coordinates
    {
        $foodResource = $this->selectPredatorTarget($this->locateFoodResources($map));
        if (!$foodResource) {
            $targetCoordinates = $this->locateMoveCoordinates($map);
        } else {
            $targetCoordinates = $foodResource->getCoordinates();
            if ($this->getCoordinates()->isCoordinateNeighbor($targetCoordinates)) {
                $this->makeAttack($foodResource);
                return $this->getCoordinates();
            }
        }

        $graph = $map->toGraph($this->environmentEvaluations, new GraphOffsets(GraphOffsets::PREDATOR_GRAPH_OFFSET));
        return $this->getStepCoordinate($map, $targetCoordinates, $graph);
    }

    public function makeAttack(Creature $creature): void
    {
        $healthAfterDamage = $creature->getHealthPoints() - $this->getAttackPower();
        $creature->setHealthPoints($healthAfterDamage);
    }

    public function generateListPositionsFromCoordinates(Map $map): array
    {
        $listOfPositions = [];
        for ($offset = 1, $maxOffset = $this->getSpeed(); $offset <= $maxOffset; $offset++) {
            $offsets = [
                $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate(0, $offset)),
                $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate($offset, $offset)),
                $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate($offset, 0)),
                $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate($offset, -$offset)),
                $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate(0, -$offset)),
                $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate(-$offset, -$offset)),
                $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate(-$offset, 0)),
                $this->getCoordinates()->shiftCoordinates(new ShiftCoordinate(-$offset, $offset)),
            ];
            $listOfPositions = [...$listOfPositions, ...$offsets];
        }

        return $listOfPositions;
    }

    public function __toString()
    {
        return "\u{1f408}";
    }

}