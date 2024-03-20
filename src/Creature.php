<?php

namespace Simulation;

use Simulation\PathFind\Graph;
use Simulation\PathFind\PathFind;

abstract class Creature extends Entity
{
    protected int $speed;
    protected int $healthPoints;
    protected array $environmentEvaluations;
    protected ?Coordinates $coordinatesForSimpleMove;

    public function __construct(
        int $speed,
        int $healthPoints,
        Coordinates $coordinates,
        array $environmentEvaluations,
    ) {
        $this->speed = $speed;
        $this->healthPoints = $healthPoints;
        $this->coordinates = $coordinates;
        $this->environmentEvaluations = $environmentEvaluations;
        $this->coordinatesForSimpleMove = null;
    }

    public function getCoordinateForSimpleMove(): ?Coordinates
    {
        return $this->coordinatesForSimpleMove;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function getEnvironmentEvaluations(): array
    {
        return $this->environmentEvaluations;
    }

    public function getHealthPoints(): int
    {
        return $this->healthPoints;
    }

    public function setHealthPoints(int $healthPoints): void
    {
        $this->healthPoints = $healthPoints;
    }

    public function setCoordinateForSimpleMove(Coordinates $coordinates): void
    {
        $this->coordinatesForSimpleMove = $coordinates;
    }

    public function generateListCoordinateMoves(array $listOfPositions, Map $map): array
    {
        $listOfMoves = [];
        foreach ($listOfPositions as $position) {
            if ($map->isPositionExists($position) && !$map->haveEntityOnPosition($position)) {
                $listOfMoves[] = $position;
            }
        }

        return $listOfMoves;
    }

    public function getStepCoordinate(Map $map, Coordinates $targetCoordinates, Graph $graph): Coordinates
    {
        $pathFind = new Pathfind($this->getCoordinates(), $targetCoordinates, $graph);
        $path = $pathFind->findPath();
        if ($path) {
            $step = array_pop($path);
            if ($map->haveEntityOnPosition($step)) {
                return $this->getCoordinates();
            }
            return $step;
        }
        return $this->getCoordinates();
    }

    public function locateFoodResources(Map $map): Targets
    {
        $foodResources = $this->findFoodResource($map);

        if (empty($foodResources)) {
            return new Targets($map);
        }

        $foodTargets = new Targets($map, $foodResources);
        return $foodTargets->calcDistanceBetweenTargets($this->getCoordinates())->setNearestTargetsFirst();
    }

    abstract public function findFoodResource(Map $map): array;

    abstract public function generateListPositionsFromCoordinates(Map $map): array;

    abstract public function locateMoveCoordinates(Map $map): ?Coordinates;

    abstract public function makeMovie(Map $map): Coordinates;
}