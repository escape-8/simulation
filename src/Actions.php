<?php

namespace Simulation;

use Simulation\Pathfind\EnvironmentEvaluations;

class Actions
{
    public function initActions(Map $map): void
    {
        for ($element = Map::$width; $element > 0; $element--) {
            if ($element < 3) {
                [$x, $y] = $map->generatePosition();
                $map->setEntity(new Coordinates($x, $y), new Predator(10, 11, new Coordinates($x, $y)));
            }
            if ($element < 17) {
                [$x, $y] = $map->generatePosition();
                $map->setEntity(new Coordinates($x, $y), new Rock());
            }
            if ($element < 20) {
                [$x, $y] = $map->generatePosition();
                $map->setEntity(new Coordinates($x, $y), new Tree());
            }

            if ($element < 11) {
                [$x, $y] = $map->generatePosition();
                $map->setEntity(new Coordinates($x, $y), new Grass());
            }

            if ($element > 10) {
                [$x, $y] = $map->generatePosition();
                $map->setEntity(new Coordinates($x, $y), new Herbivore(5, 5, new Coordinates($x, $y)));
            }
        }
    }

    public function turnActions(Map $map): void
    {
        $predators = $map->getEntitiesByType(Predator::class);
        foreach ($predators as $coordinates => $predator) {
            $predator->makeMovie();
            $map->removePosition($coordinates);
            $map->setEntity($predator->getCoordinates(), $predator);
        }
    }
}