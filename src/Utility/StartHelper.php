<?php

namespace Simulation\Utility;

class StartHelper
{
    public function getWidth(): int
    {
        system('clear');
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
        system('clear');
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
