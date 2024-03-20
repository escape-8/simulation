<?php

namespace Simulation\Utility;

use Simulation\View\ConsoleMapRenderer;

class StartHelper
{
    public function getWidth(): int
    {
        echo ConsoleMapRenderer::ANSI_CLEAR_TERMINAL_WINDOW;
        echo "Set width (number from 3 to 30) \n";
        $width = readline();

        while ($width < 3 || $width > 30) {
            echo "Incorrect number $width \n";
            echo "Set width (number from 3 to 30) \n";
            $width = readline();
        }

        return $width;
    }

    public function getHeight(): int
    {
        echo ConsoleMapRenderer::ANSI_CLEAR_TERMINAL_WINDOW;
        echo "Set height (number from 3 to 15) \n";
        $height = readline();

        while ($height < 3 || $height > 15) {
            echo "Incorrect number $height \n";
            echo "Set width (number from 3 to 15) \n";
            $height = readline();
        }

        return $height;
    }
}
