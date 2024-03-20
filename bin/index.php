#! /usr/bin/env php

<?php

require_once __DIR__ . '/../src/ClassAutoload/autoload.php';

use Simulation\Utility\StartHelper;
use Simulation\Simulation;
use Simulation\View\ConsoleMapRenderer;
use Simulation\Map\Map;


$start = new StartHelper();
$width = $start->getWidth();
$height = $start->getHeight();

$simulation = new Simulation(new Map($width, $height), new ConsoleMapRenderer());

$simulation->startSimulation();
