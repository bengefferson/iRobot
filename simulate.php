#!/usr/bin/env php
<?php
declare(strict_types=1);
session_start();

require 'vendor/autoload.php';


use iRobot\TwoDimension\Board\SquareBoard;
use iRobot\TwoDimension\Service\PlaceRobotService;
use iRobot\TwoDimension\Service\MoveRobotService;
use iRobot\TwoDimension\Robot;
use iRobot\Simulator;


//Create required classes
$board = new SquareBoard;
$place = new PlaceRobotService($board);
$move = new MoveRobotService($place);
$robot = new Robot($place,$move);
$simulate = new Simulator($robot);

// Parse command line arguments and run. If no file is parsed, stdin is used

$source = $argv[1] ?? 'php://stdin';

echo "Please enter commands starting with PLACE as shown in the README.md.\n
If no coordinates and orientation are given, the system defaults them to 0,0,NORTH.\n
To print out current position, type command 'REPORT'.\n
A maximum of 50 lines can be entered fro the commandline. Use ctrl+c to quit. \n
---------------Start---------------------\n";
$simulate->run($source);



?>