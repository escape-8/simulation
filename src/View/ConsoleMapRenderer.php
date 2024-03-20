<?php

namespace Simulation\View;

use Simulation\Coordinates\Coordinates;
use Simulation\Map\Map;

class ConsoleMapRenderer
{
    public const ANSI_CLEAR_TERMINAL_WINDOW = "\033[H\033[J";
    private const EMPTY_SYMBOL = "\u{0020}";
    private const BYTES_IN_UNICODE_SYMBOL = 2;
    private const ANSI_BG_COLOR = "\u{001B}[48;5;235m";
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
                    $line[] = self::ANSI_BG_COLOR . $emptyPart . self::ANSI_RESET_COLOR;
                }
            }
            $strLine = implode(' ', $line) . "\n";
            echo $strLine;
        }
    }
}