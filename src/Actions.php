<?php

namespace Simulation;

use Simulation\Pathfind\EnvironmentEvaluations;

class Actions
{
    public function initActions(Map $map): void
    {
        $countEntitiesOnMapInPercent = [
            Tree::class => 8,
            Rock::class => 8,
            Grass::class => 7,
            Predator::class => 0.4,
            Herbivore::class => 3,
        ];

        $numberOfEntities = $this->conversionPercentEntitiesToNumbers($countEntitiesOnMapInPercent, $map);

        $entityFactory = new EntityFactory(new EnvironmentEvaluations());

        foreach ($numberOfEntities as $entity => $count) {
            for ($num = $count; $num >= 0; $num--) {
                $position = $this->generateStartRandomPosition($map);
                $map->setEntity($position, $entityFactory->create($entity, $position));
            }
        }
    }

    public function turnActions(Map $map, ConsoleMapRenderer $renderer): void
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
        $renderer->render($map);
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