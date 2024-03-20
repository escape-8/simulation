<?php

namespace Simulation;

use Simulation\Actions\InitActions;
use Simulation\Actions\TurnActions;
use Simulation\Entities\Herbivore;
use Simulation\Map\Map;
use Simulation\View\ConsoleMapRenderer;

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

    public function nextTurn(): void
    {
        $turnAction = new TurnActions();
        $turnAction->action($this->map);
    }

    public function startSimulation(): void
    {
        if ($this->getMovies() === 0) {
            system('clear');
            echo "\n";
            $initActions = new InitActions();
            $initActions->action($this->map);
            $this->increaseMovies();
            $this->renderer->render($this->map);
            echo "\n";
        }

        while(count($this->map->getEntitiesByClass(Herbivore::class)) > 0) {
            system('clear');
            echo "\n";
            echo "Round: " . $this->getMovies() . "\n";
            $this->nextTurn();
            $this->increaseMovies();
            $this->renderer->render($this->map);
            echo "\n";
            $this->pauseSimulation();
        }
    }

    public function pauseSimulation(): void
    {
        sleep(1);
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