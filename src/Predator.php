<?php

namespace Simulation;

use Simulation\PathFind\GraphOffsets;

class Predator extends Creature
{
    private int $attackPower = 5;

    public function makeMovie()
    {
        // TODO: Implement makeMovie() method.
        return false;
    }

    public function makeAttack()
    {
        // TODO: Implement makeAttack() method.
        return false;
    }

    public function __toString()
    {
        return "\u{1f408}";
    }

}