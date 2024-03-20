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
}