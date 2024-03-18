<?php

namespace Simulation\PathFind;

use Simulation\Coordinates;

class Graph
{
    private array $nodes;

    public function __construct()
    {
        $this->nodes = [];
    }

    public function isCoordinateNodeExists(Coordinates $coordinates): bool
    {
        return isset($this->nodes[(string)$coordinates]);
    }

    public function getNode(Coordinates $coordinates): Node
    {
        return $this->nodes[(string)$coordinates];
    }

    public function addNode(Node $node): void
    {
        $this->nodes[(string)$node] = $node;
    }

    public function makeNeighbors(Node $node1, Node $node2): void
    {
        $node1->setNeighbor($node2);
        $node2->setNeighbor($node1);
    }
}
