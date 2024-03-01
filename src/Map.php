<?php

namespace Simulation;

class Map
{
    public static int $width = 20;
    public static int $height = 10;
    private array $entities;

    public function setEntities(Coordinates $coordinates, Entity $entity): void
    {
        $entity->setCoordinates($coordinates);
        $this->entities[(string)$coordinates] = $entity;
    }

    public function setupStartPositions(): void
    {
        for ($row = 0; $row < self::$width; $row++) {

            if ($row < 2) {
                [$x, $y] = $this->generatePosition();
                $this->setEntities(new Coordinates($x, $y), new Predator(10, 11, new Coordinates($x, $y)));
            }
            if ($row < 10) {
                [$x, $y] = $this->generatePosition();
                $this->setEntities(new Coordinates($x, $y), new Rock());
            }
            if ($row < 23) {
                [$x, $y] = $this->generatePosition();
                $this->setEntities(new Coordinates($x, $y), new Tree());
            }

            if ($row < 11) {
                [$x, $y] = $this->generatePosition();
                $this->setEntities(new Coordinates($x, $y), new Grass());
            }

            if ($row < 10) {
                [$x, $y] = $this->generatePosition();
                $this->setEntities(new Coordinates($x, $y), new Herbivore(5, 5, new Coordinates($x, $y)));
            }
        }
    }

    public function generatePosition(): array
    {
        $x = random_int(0, self::$width - 1);
        $y = random_int(0, self::$height - 1);

        if ($this->haveEntityOnPosition($x, $y)) {
            return $this->generatePosition();
        }

        return [$x, $y];
    }
    public function haveEntityOnPosition(int $x, int $y): bool
    {
        return isset($this->entities["$x:$y"]);
    }

    public function getEntity($x, $y): Entity
    {
        return $this->entities["$x:$y"];
    }
}
