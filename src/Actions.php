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