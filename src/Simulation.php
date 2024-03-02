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

    public function startSimulation(): void
    {
        $this->actions->initActions($this->map);
        $this->renderer->render($this->map);
    }

    public function pauseSimulation(): void
    {
    }

    public function getMovies(): int
    {
        return $this->countMovies;
    }

    public function increaseMovies(): void
    {
        $this->countMovies++;
    }

}