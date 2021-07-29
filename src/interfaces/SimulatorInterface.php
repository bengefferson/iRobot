<?php

namespace iRobot\Interfaces;

//Base robot interface for any number of dimensions
interface SimulatorInterface 
{
    //Runs commands from file parsed
    public function run(string $source) :void ;
}
?>