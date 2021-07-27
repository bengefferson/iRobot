<?php

namespace iRobot\Interfaces;

//Base robot interface for any number of dimensions
interface RobotInterface 
{
    //All robots can get permissible commands
    public function getCommands():array;

    //All robots can execute permissible commands
    public function execute(array $command):void;
}
?>