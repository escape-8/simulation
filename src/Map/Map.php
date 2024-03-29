<?php

namespace Simulation\Map;

use Simulation\Coordinates\Coordinates;
use Simulation\Entities\Entity;
use Simulation\Entities\Grass;
use Simulation\Entities\Herbivore;
use Simulation\Entities\Predator;
use Simulation\Entities\Rock;
use Simulation\Entities\Tree;
use Simulation\PathFind\Graph;
use Simulation\PathFind\GraphOffsets;
use Simulation\PathFind\Node;

class Map
{
    private const COUNT_ENTITIES_ON_MAP_IN_PERCENT =
        [
            Tree::class => 8,
            Rock::class => 8,
            Grass::class => 7,
            Predator::class => 1,
            Herbivore::class => 5,
        ];
    public const MIN_COORDINATE = 1;
    private int $width;
    private int $height;
    private array $entities;


    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
        $this->entities = [];
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getCountEntitiesOnMapInPercent(): array
    {
        return self::COUNT_ENTITIES_ON_MAP_IN_PERCENT;
    }

    public function setEntity(Coordinates $coordinates, Entity $entity): void
    {
        $entity->setCoordinates($coordinates);
        $this->entities[(string)$coordinates] = $entity;
    }

    public function haveEntityOnPosition(Coordinates $coordinates): bool
    {
        return array_key_exists((string)$coordinates, $this->entities);
    }

    public function filterNotExistsPositions(array $positions): array
    {
        return array_filter($positions, fn($position) => $this->isPositionExists($position));
    }

    public function isPositionExists(Coordinates $coordinates): bool
    {
        $x = $coordinates->getCoordX();
        $y = $coordinates->getCoordY();
        if ($x < self::MIN_COORDINATE || $x > $this->getWidth()) {
            return false;
        }

        if ($y < self::MIN_COORDINATE || $y > $this->getHeight()) {
            return false;
        }

        return true;
    }

    public function getEntity(Coordinates $coordinates): ?Entity
    {
        return $this->entities[(string)$coordinates] ?? null;
    }

    public function getEntitiesByClass(string $class): array
    {
        $res = [];
        foreach ($this->entities as $entity) {
            if ($entity instanceof $class) {
                $res[] = $entity;
            }
        }
        return $res;
    }

    public function removePosition(Coordinates $coordinates): void
    {
        unset($this->entities[(string)$coordinates]);
    }

    public function toGraph(array $environmentEvaluations, GraphOffsets $graphOffsets): Graph
    {
        $graph = new Graph();
        $offsets = $graphOffsets->getOffsets();
        $coordinateNeighbors = [];

        for ($cellY = $this->getHeight(); $cellY >= self::MIN_COORDINATE; $cellY--) {
            for ($cellX = self::MIN_COORDINATE; $cellX <= $this->getWidth(); $cellX++) {
                $position = new Coordinates($cellX, $cellY);
                $node = new Node($position);

                if ($this->haveEntityOnPosition($position)) {
                    $entityEvaluation = $environmentEvaluations[$this->getEntity($position)::class];
                } else {
                    $entityEvaluation = $environmentEvaluations[$position::class];
                }

                $node->setCost($entityEvaluation['cost']);
                $node->setHaveField($entityEvaluation['haveField']);

                if ($entityEvaluation['haveField'] === true) {
                    $node->setFieldCost($entityEvaluation['fieldCost']);
                }

                $positionNeighbors = [];
                foreach ($offsets as $offset) {
                    $positionNeighbors[] = $position->shiftCoordinates($offset);
                }

                $coordinateNeighbors[] = [
                    'node' => $node,
                    'neighbors' => $this->filterNotExistsPositions($positionNeighbors)
                ];

                $graph->addNode($node);
            }
        }

        foreach ($coordinateNeighbors as ['node' => $node, 'neighbors' => $coordinatesNeighbours]) {
            foreach ($coordinatesNeighbours as $coordinateNeighbour) {
                $nodeNeighbour = $graph->getNode($coordinateNeighbour);
                if ($node->isHaveField()) {
                    $nodeNeighbour->setCost($nodeNeighbour->getCost() + $node->getFieldCost());
                }
                $graph->makeNeighbors($node, $nodeNeighbour);
            }
        }
        return $graph;
    }

    public function conversionPercentEntitiesToNumbers(): array
    {
        $result = [];
        $countCells = $this->getHeight() * $this->getWidth();
        $percentDelimiter = 100;

        foreach ($this->getCountEntitiesOnMapInPercent() as $entity => $percent) {
            $result[$entity] = round(($percent * $countCells) / $percentDelimiter);
        }

        return $result;
    }
}
