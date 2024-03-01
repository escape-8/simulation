<?php

spl_autoload_register(function ($class) {
    $rootNamespace = 'Simulation\\';
    $file =  __DIR__ . '/../src/' . str_replace($rootNamespace, '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

use Simulation\Simulation;
use Simulation\ConsoleMapRenderer;
use Simulation\Map;

$simulation = new Simulation(new Map(), new ConsoleMapRenderer());
system('clear');
echo "\n";
$simulation->startSimulation();
echo "\n";
