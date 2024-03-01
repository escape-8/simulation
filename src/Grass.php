<?php

namespace Simulation;
class Grass extends Entity
{
    private const GRASS =  ["\u{1F353}", "\u{1F330}", "\u{1F33D}"];
    public function __toString(): string
    {
        $count = count(self::GRASS) - 1;
        $symbol = random_int(0, $count);
        return self::GRASS[$symbol];
    }
}