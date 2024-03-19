<?php

namespace Simulation;

class Targets
{
    private Map $map;
    private array $targets;

    public function __construct(Map $map, array $targets = [])
    {
        $this->map = $map;
        $this->targets = $targets;
    }

    public function getTargets(): array
    {
        return $this->targets;
    }

    public function calcDistanceBetweenTargets(Coordinates $calcFrom): Targets
    {
        $distances = [];
        foreach ($this->targets as $target) {
            $distance = $calcFrom->calcCoordinateDistance($target->getCoordinates());
            $distances[] = ['distance' => $distance, 'target' => $target];
        }
        return new Targets($this->map, $distances);
    }

    public function setNearestTargetsFirst(): Targets
    {
        usort($this->targets, fn($a, $b) => $b['distance'] <=> $a['distance']);
        return $this;
    }

    public function setFarTargetsFirst(): Targets
    {
        usort($this->targets, fn($a, $b) => $a['distance'] <=> $b['distance']);
        return $this;
    }

    public function getTarget(): mixed
    {
        return array_pop($this->targets)['target'];
    }

    public function haveTargets(): bool
    {
        return !empty($this->targets);
    }

    public function shuffleTargets(): Targets
    {
        shuffle($this->targets);
        return new Targets($this->map, $this->targets);
    }
}