<?php

namespace Simulation\PathFind;

use Simulation\Coordinates;

class Node
{
    private Coordinates $coordinates;
    private ?Node $previous;
    private array $neighbors;
    private ?int $cost;
    private ?int $fieldCost;
    private bool $haveField;

    public function __construct(Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;
        $this->previous = null;
        $this->neighbors = [];
        $this->cost = null;
        $this->fieldCost = null;
        $this->haveField = false;
    }

    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

    public function getNeighbors(): array
    {
        return $this->neighbors;
    }

    public function getPrevious(): ?Node
    {
        return $this->previous;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function getFieldCost(): ?int
    {
        return $this->fieldCost;
    }

    public function isHaveField(): bool
    {
        return $this->haveField;
    }

    public function setPrevious(Node $node): void
    {
        $this->previous = $node;
    }

    public function setNeighbor(Node $node): void
    {
        $this->neighbors[] = $node;
    }

    public function setCost(int $cost): void
    {
        $this->cost = $cost;
    }

    public function setFieldCost(?int $fieldCost): void
    {
        $this->fieldCost = $fieldCost;
    }

    public function setHaveField(bool $haveField): void
    {
        $this->haveField = $haveField;
    }

    public function __toString()
    {
        return (string) $this->getCoordinates();
    }
}
