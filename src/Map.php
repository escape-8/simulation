<?php

namespace Simulation;

use Simulation\PathFind\Graph;
use Simulation\PathFind\GraphOffsets;
use Simulation\PathFind\Node;

class Map
{
    public static int $width = 20;
    public static int $height = 10;
    private array $entities;

    public function setEntities(Coordinates $coordinates, Entity $entity): void
    {
        $entity->setCoordinates($coordinates);
        $this->entities[(string)$coordinates] = $entity;
    }

    public function setupStartPositions(): void
    {
        for ($row = 0; $row < self::$width; $row++) {

            if ($row < 2) {
                [$x, $y] = $this->generatePosition();
                $this->setEntities(new Coordinates($x, $y), new Predator(10, 11, new Coordinates($x, $y)));
            }
            if ($row < 10) {
                [$x, $y] = $this->generatePosition();
                $this->setEntities(new Coordinates($x, $y), new Rock());
            }
            if ($row < 23) {
                [$x, $y] = $this->generatePosition();
                $this->setEntities(new Coordinates($x, $y), new Tree());
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

    public function getEntity($x, $y): Entity
    {
        return $this->entities["$x:$y"];
    }
}
