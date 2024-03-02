<?php

namespace Simulation;

class Simulation
{
    private Map $map;
    private ConsoleMapRenderer $renderer;
    private Actions $actions;
    private int $countMovies;

    public function __construct(Map $map, ConsoleMapRenderer $renderer, Actions $actions)
    {
        $this->map = $map;
        $this->renderer = $renderer;
        $this->actions = $actions;
        $this->countMovies = 0;
    }

    public function nextTurn(): void
    {
        $this->actions->turnActions($this->map);
        $this->renderer->render($this->map);
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