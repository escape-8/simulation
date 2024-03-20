<?php

namespace Simulation;

use Simulation\PathFind\GraphOffsets;

class Predator extends Creature
{
    private int $attackPower = 5;

    public function getAttackPower(): int
    {
        return $this->attackPower;
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