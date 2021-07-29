<?php

namespace iRobot;
ini_set('include_path','/var/www/src/2D/commands');

use Exception;
use iRobot\TwoDimension\Service\CleanInputService;
use iRobot\Interfaces\RobotInterface;
use iRobot\Interfaces\SimulatorInterface;

//This class handles the simulation of how the robot behaves when given a series of commands
class Simulator implements SimulatorInterface
{
    protected $robot;

    const MAX_FILE_SIZE = 3072;
    const DEFAULT_FILE_SIZE = 2048;
    const MAX_LINES_FOR_COMMANDLINE = 50;


    public function __construct(RobotInterface $robot)
    {
        $this->robot = $robot;
    }

    //Runs commands from file parsed
    public function run(string $source) :void
    {
        $handle = fopen($source, "r", true);

        //Handles Commandline inputs. Allows Maximum of 50 lines
        if ($source == "php://stdin"){
            $start = 0;
            while ($start < self::MAX_LINES_FOR_COMMANDLINE) {
                $command = fgets($handle);
                try{
                    $command = CleanInputService::parseCommand($command);
                    $this->robot->execute($command);
                }catch(Exception $e){   
                    echo $e->getMessage();
                    echo "\n";
                }
                $start +=1;
            }
            fclose($handle);
        }else{

            //Handles for files in /var/www/src/2D/commands/ directory. Maximum file size allowed is 3mb
            try{
                $fileSize = filesize('/var/www/src/2D/commands/'.$source);
            }catch(Exception $e){}

            if(! $fileSize){
                $fileSize =self::DEFAULT_FILE_SIZE;
            }

            if ($fileSize > self::MAX_FILE_SIZE){
                throw new Exception("File size should be greater than 3MB");
            }
            $contents = fread($handle, $fileSize);
            fclose($handle);
            $contents = explode("\n",$contents);
            foreach($contents as $content){
                if ($content == "```plain"){
                    continue;
                }elseif($content == "```"){
                    break;
                }
                $command = $content;
                try{
                    $command = CleanInputService::parseCommand($command);
                    $this->robot->execute($command);
                }catch(Exception $e){
                    echo $e->getMessage();
                    echo "\n";
                }   
            }
        }

    }
    
}