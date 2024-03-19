<?php

namespace Simulation\Actions;

use Simulation\Creature;
use Simulation\EntityFactory;
use Simulation\Grass;
use Simulation\Map;
use Simulation\PathFind\EnvironmentEvaluations;

class TurnActions extends Actions
{
    public function action(Map $map): void
    {
        $creatures = $map->getEntitiesByClass(Creature::class);
        foreach ($creatures as $creature) {
            if ($creature->getHealthPoints() <= 0) {
                $map->removePosition($creature->getCoordinates());
                continue;
            }
            for ($step = 0; $step < $creature->getSpeed(); $step++) {
                $map->removePosition($creature->getCoordinates());
                $coordinate = $creature->makeMovie($map);
                $map->setEntity($coordinate, $creature);
            }
        }

        if ($this->isAddGrass($map)) {
            $this->addGrass($map);
        }
    }

    public function addGrass(Map $map): void
    {
        $entityFactory = new EntityFactory(new EnvironmentEvaluations());
        for ($num = $this->calcCountGrassAdd($map); $num >= 0; $num--) {
            $position = $this->generateStartRandomPosition($map);
            $map->setEntity($position, $entityFactory->create(Grass::class, $position));
        }
    }

    public function isAddGrass(Map $map): bool
    {
        return $this->getCurrentGrassOnMap($map) < $this->getMinNeedleGrass($map);
    }

    public function getCurrentGrassOnMap(Map $map): int
    {
        return count($map->getEntitiesByClass(Grass::class));
    }

    public function getBaseGrassOnMap(Map $map): int
    {
        return $map->getCountEntitiesOnMapInPercent()[Grass::class];
    }

    public function getMinNeedleGrass(Map $map): int
    {
        return (int) round($this->getBaseGrassOnMap($map) / 3);
    }

    public function calcCountGrassAdd(Map $map): int
    {
        return $this->getMinNeedleGrass($map) - $this->getCurrentGrassOnMap($map);
    }
}
