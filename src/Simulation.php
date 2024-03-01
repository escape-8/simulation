<?php

namespace Simulation;

class Simulation
{
    private Map $map;
    private ConsoleMapRenderer $renderer;
    private int $countMovies;

    public function __construct(Map $map, ConsoleMapRenderer $renderer)
    {
        $this->map = $map;
        $this->renderer = $renderer;
        $this->countMovies = 0;
    }

    public function getMap(): Map
    {
        return $this->map;
    }

    public function nextTurn()
    {
    }

    public function startSimulation(): void
    {
        $this->map->setupStartPositions();
        $this->renderer->render($this->map);
    }

    public function pauseSimulation()
    {
    }
}