<?php

namespace Simulation;

class Coordinates
{
    private int $coordX;
    private int $coordY;

    public function __construct(int $coordX, int $coordY)
    {
        $this->coordX = $coordX;
        $this->coordY = $coordY;
    }

    public function shiftCoordinates(ShiftCoordinate $shift): Coordinates
    {
        $x = $this->getCoordX() + $shift->getMoveX();
        $y = $this->getCoordY() + $shift->getMoveY();
        return new Coordinates($x, $y);
    }

    public function __toString()
    {
        return $this->getCoordX() . ':' . $this->getCoordY();
    }

    public function getCoordX(): int
    {
        return $this->coordX;
    }

    public function getCoordY(): int
    {
        return $this->coordY;
    }

    public function getCoordinates(): Coordinates
    {
        return $this;
    }

    public function equals(Coordinates $coordinates): bool
    {
        return $this->getCoordX() === $coordinates->getCoordX() && $this->getCoordY() === $coordinates->getCoordY();
    }

    public function isCoordinateNeighbor(Coordinates $coordinates): bool
    {
        return $this->calcCoordinateDistance($coordinates) < 2;
    }

    public function calcCoordinateDistance(Coordinates $coordinates): float
    {
        return sqrt(
            abs($this->coordX - $coordinates->getCoordX()) ** 2 +
            abs($this->coordY - $coordinates->getCoordY()) ** 2
        );
    }

    public function calcNeighbors(int $calcLimit = 1): array
    {
        $result = [];
        $directions = 8;
        $x = $this->coordX;
        $y = $this->coordY;
        for ($calcDepth = $calcLimit; $calcDepth > 0; $calcDepth--) {
            for ($direction = 1; $direction <= $directions; $direction++) {
                $neighborCoordinate = null;
                switch ($direction) {
                    case 1 :
                        $neighborCoordinate = new self($x, $y + $calcDepth);
                        break;
                    case 2 :
                        $neighborCoordinate = new self($x + $calcDepth, $y + $calcDepth);
                        break;
                    case 3 :
                        $neighborCoordinate = new self($x + $calcDepth, $y);
                        break;
                    case 4 :
                        $neighborCoordinate = new self($x + $calcDepth, $y - $calcDepth);
                        break;
                    case 5 :
                        $neighborCoordinate = new self($x, $y - $calcDepth);
                        break;
                    case 6 :
                        $neighborCoordinate = new self($x - $calcDepth, $y - $calcDepth);
                        break;
                    case 7 :
                        $neighborCoordinate = new self($x - $calcDepth, $y);
                        break;
                    case 8 :
                        $neighborCoordinate = new self($x - $calcDepth, $y + $calcDepth);
                        break;
                }
                $result[(string)$neighborCoordinate] = $neighborCoordinate;
            }
        }
        return $result;
    }
}