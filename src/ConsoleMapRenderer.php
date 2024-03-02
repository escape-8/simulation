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
        for ($positionY = Map::$height; $positionY > 0; $positionY--) {
            $line = [];
            for ($positionX = Map::$width; $positionX > 0; $positionX--) {
                if ($map->haveEntityOnPosition($positionX, $positionY)) {
                    $line[] = $map->getEntity($positionX, $positionY);
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