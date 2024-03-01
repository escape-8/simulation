<?php

namespace Simulation;

class Tree extends Entity
{
    private const TREES = ["\u{1F333}", "\u{1F332}"];

    public function __toString()
    {
        $symbol = random_int(0, count(self::TREES) - 1);
        return self::TREES[$symbol];
    }
}