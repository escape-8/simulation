# Simulation

![simulation preview](https://live.staticflickr.com/65535/53600087601_a82bc221a6_b.jpg)

The essence of the project is a step-by-step simulation of a 2D world inhabited by herbivores and predators. In addition to existence, the world contains resources (grass) that herbivores feed on and static objects that can be interacted with - they just take up space.

This project is a cat-and-mouse adaptation. And the food resource is cheese.

The 2D world is an NxM matrix, each creature or object contains cells of a cell, the presence of several objects/creatures in a cell is unacceptable.

The goal of the project is to develop object-oriented programming skills, as well as algorithms and data structures. For example, path search is implemented using the A-star algorithm, which in turn is based on breadth-first search and Dijkstra's algorithm. A directed graph based on an adjacency list has been implemented.

#### Install Required
* php >= 8.0
* XAMPP (for OS Windows)

#### Get Started

* Linux

> $ git clone https://github.com/escape-8/simulation.git

> $ cd path/to/simulation

> $ make simulation or php bin/simulation

> Set width and height of map

> view simulation in terminal

* Windows

> Download XAMPP 

> Set up XAMPP in C: disk as default (it's important) 

> $ git clone https://github.com/escape-8/simulation.git

> $ cd path/to/simulation

> $ C:\xampp\php\php.exe bin/simulation

> Set width and height of map

> view simulation in terminal