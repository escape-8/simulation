<?php

namespace Simulation;

class ConsoleMapRenderer
{
    private const EMPTY_SYMBOL = "\u{0020}";
    private const BYTES_IN_UNICODE_SYMBOL = 2;
    private const ANSI_BG_COLOR = "\u{001B}[0;100m";
    private const ANSI_RESET_COLOR = "\u{001B}[0m";
    public function render(Map $map): void
    {
        for ($positionY = $map->getHeight(); $positionY >= Map::MIN_COORDINATE; $positionY--) {
            $line = [];
            for ($positionX = Map::MIN_COORDINATE; $positionX <= $map->getWidth(); $positionX++) {
                $coordinates = new Coordinates($positionX, $positionY);
                if ($map->haveEntityOnPosition($coordinates)) {
                    $line[] = $map->getEntity($coordinates);
                } else {
                    $emptyPart = str_repeat(self::EMPTY_SYMBOL, self::BYTES_IN_UNICODE_SYMBOL);
                    $line[] = self::ANSI_BG_COLOR .  $emptyPart . self::ANSI_RESET_COLOR;
                }
            }
            $strLine = implode(' ', $line) . "\n";
            echo $strLine;
        }
    }
}