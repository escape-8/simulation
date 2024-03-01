<?php

namespace Simulation;

class ConsoleMapRenderer
{
    private const EMPTY_SYMBOL = "\u{0020}";
    public function render(Map $map): void
    {
        for ($positionY = 0; $positionY < Map::$height; $positionY++) {
            $line = [];
            for ($positionX = 0; $positionX < Map::$width; $positionX++) {
                if ($map->haveEntityOnPosition($positionX, $positionY)) {
                    $line[] = $map->getEntity($positionX, $positionY);
                } else {
                    $line[] = self::EMPTY_SYMBOL;
                }
            }
            $strLine = implode(' ', $line) . "\n";
            echo $strLine;
        }
    }
}