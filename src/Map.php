<?php

namespace Simulation;

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

    public function setEntities(Coordinates $coordinates, Entity $entity): void
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

            if ($row < 11) {
                [$x, $y] = $this->generatePosition();
                $this->setEntities(new Coordinates($x, $y), new Grass());
            }

            if ($row < 10) {
                [$x, $y] = $this->generatePosition();
                $this->setEntities(new Coordinates($x, $y), new Herbivore(5, 5, new Coordinates($x, $y)));
            }
        }
    }

    public function generatePosition(): array
    {
        $x = random_int(0, self::$width - 1);
        $y = random_int(0, self::$height - 1);

        if ($this->haveEntityOnPosition($x, $y)) {
            return $this->generatePosition();
        }

        return [$x, $y];
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
