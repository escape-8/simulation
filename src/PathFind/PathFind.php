<?php

namespace Simulation\PathFind;

use Simulation\Coordinates;

class PathFind
{
    private Coordinates $startPoint;
    private Coordinates $endPoint;
    private Graph $graph;

    public function __construct(Coordinates $startPoint, Coordinates $endPoint, Graph $graph)
    {
        $this->startPoint = $startPoint;
        $this->endPoint = $endPoint;
        $this->graph = $graph;
    }

    public function findPath(): ?array
    {
        $start = $this->graph->getNode($this->startPoint);
        $end = $this->graph->getNode($this->endPoint);
        $reachable[(string)$start] = $start;
        $explored = [];

        while (!empty($reachable)) {
            $node = $this->chooseNode($reachable, $end);
            unset($reachable[(string)$node]);
            $explored[(string)$node] = $node;

            if ($node->getCoordinates()->equals($end->getCoordinates())) {
                return $this->buildPath($node);
            }

            $newReachable = $node->getNeighbors();
            foreach ($newReachable as $nodeNeighbour) {
                if (!isset($explored[(string)$nodeNeighbour]) && !isset($reachable[(string)$nodeNeighbour])) {
                    $nodeNeighbour->setPrevious($node);
                    $reachable[(string)$nodeNeighbour] = $nodeNeighbour;
                }
            }
        }
        return null;
    }

    private function buildPath(Node $nodeFrom): array
    {
        $path = [];
        while ($nodeFrom->getPrevious()) {
            $path[(string)$nodeFrom] = $nodeFrom->getCoordinates();
            $nodeFrom = $nodeFrom->getPrevious();
        }
        return $path;
    }

    private function chooseNode(array $reachable, Node $endNode): Node
    {
        $minCost = INF;
        $lowCostNode = null;

        foreach ($reachable as $node) {
            $currNodeCost = $node->getCost();
            $estimateDistance = $node->getCoordinates()->calcCoordinateDistance($endNode->getCoordinates());
            $totalCost = $currNodeCost + $estimateDistance;
            if ($totalCost < $minCost) {
                $lowCostNode = $node;
                $minCost = $totalCost;
            }
        }
        return $lowCostNode;
    }
}
