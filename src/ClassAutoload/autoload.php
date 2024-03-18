<?php

spl_autoload_register(function ($class) {
    $rootNamespace = 'Simulation\\';
    $search = [$rootNamespace, "\\"];
    $file =  __DIR__ . '/../../src/' . str_replace($search, '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
