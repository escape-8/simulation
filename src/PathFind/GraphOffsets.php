<?php

namespace Simulation\PathFind;

use Simulation\ShiftCoordinate;

class GraphOffsets
{
    public const PREDATOR_GRAPH_OFFSET = [[1, 1], [1, 0], [1, -1], [0, 1]];
    public const HERBIVORE_GRAPH_OFFSET = [[1, 0], [0, 1]];

    private array $graphOffset;

    public function __construct(array $graphOffset)
    {
        $this->graphOffset = $graphOffset;
    }

    public function getOffsets(): array
    {
        $result = [];
        foreach ($this->graphOffset as $offset) {
            $result[] = new ShiftCoordinate($offset[0], $offset[1]);
        }
        return $result;
    }
}
