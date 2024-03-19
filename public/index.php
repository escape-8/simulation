<?php

require_once __DIR__ . '/../src/ClassAutoload/autoload.php';

use Simulation\Simulation;
use Simulation\ConsoleMapRenderer;
use Simulation\Map;

$simulation = new Simulation(new Map(), new ConsoleMapRenderer());
system('clear');
echo "\n";
$simulation->startSimulation();
echo "\n";
