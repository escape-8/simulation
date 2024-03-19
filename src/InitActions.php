<?php

namespace Simulation\Actions;

use Simulation\EntityFactory;
use Simulation\Map;
use Simulation\PathFind\EnvironmentEvaluations;

class InitActions extends Actions
{
    public function action(Map $map): void
    {
        $numberOfEntities = $map->conversionPercentEntitiesToNumbers();

        $entityFactory = new EntityFactory(new EnvironmentEvaluations());

        foreach ($numberOfEntities as $entity => $count) {
            for ($num = $count; $num >= 0; $num--) {
                $position = $this->generateStartRandomPosition($map);
                $map->setEntity($position, $entityFactory->create($entity, $position));
            }
        }
    }
}
