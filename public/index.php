<?php

require_once __DIR__ . '/../src/ClassAutoload/autoload.php';

use Simulation\Helpers\StartHelper;
use Simulation\Simulation;
use Simulation\ConsoleMapRenderer;
use Simulation\Map;

$start = new StartHelper();
$width = $start->getWidth();
$height = $start->getHeight();

$simulation = new Simulation(new Map($width, $height), new ConsoleMapRenderer());

$simulation->startSimulation();
echo "\n";
