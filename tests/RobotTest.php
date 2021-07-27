<?php
declare(strict_types=1);
namespace Test;
session_start();

use iRobot\TwoDimension\Service\MoveRobotService;
use iRobot\TwoDimension\Service\PlaceRobotService;
use iRobot\TwoDimension\Robot;
use iRobot\TwoDimension\Board\SquareBoard;
use Test\TestCase;
use LogicException;
use InvalidArgumentException;

class RobotTest extends TestCase
{
    
    public function setUp() :void
    {
        parent::setUp();

        $this->board = $this->mock(SquareBoard::class);
        $this->place = $this->mock(PlaceRobotService::class, [$this->board]);
        $this->move = $this->mock(MoveRobotService::class, [$this->place]);
        $this->robot = $this->mock(Robot::class, [$this->place,$this->move]);
    }

    public function testRobotExecutingCommandGivesExpectedOutputWhenPlaced()
    {
        $this->place->placeOnBoard();
        $this->robot->execute(['PLACE',[0,0,'SOUTH']]);
        $this->assertEquals($this->place->getPosition(),['x'=>0, 'y'=>0, 'orientation'=>'SOUTH']);

        $this->place->placeOnBoard();
        $this->robot->execute(['PLACE',[6,6,'EAST']]);
        $this->assertEquals($this->place->getPosition(),['x'=>6, 'y'=>6, 'orientation'=>'EAST']);

        $this->place->placeOnBoard();
        $this->robot->execute(['PLACE']);
        $this->assertEquals($this->place->getPosition(),['x'=>0, 'y'=>0, 'orientation'=>'NORTH']);

        $this->place->placeOnBoard();
        $this->robot->execute(['MOVE']);
        $this->assertEquals($this->place->getPosition(),['x'=>0, 'y'=>1, 'orientation'=>'NORTH']);

        $this->place->placeOnBoard();
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['MOVE']);
        $this->assertEquals($this->place->getPosition(),['x'=>0, 'y'=>6, 'orientation'=>'NORTH']);

        $this->place->placeOnBoard();
        $this->robot->execute(['RIGHT']);
        $this->assertEquals($this->place->getPosition(),['x'=>0, 'y'=>0, 'orientation'=>'EAST']);

        $this->place->placeOnBoard();
        $this->robot->execute(['LEFT']);
        $this->assertEquals($this->place->getPosition(),['x'=>0, 'y'=>0, 'orientation'=>'WEST']);

        $this->place->placeOnBoard();
        $this->robot->execute(['REPORT']);
        $this->assertEquals($this->place->getPosition(),['x'=>0, 'y'=>0, 'orientation'=>'NORTH']);

        $this->place->placeOnBoard();
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['RIGHT']);
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['REPORT']);
        $this->assertEquals($this->place->getPosition(),['x'=>2, 'y'=>2, 'orientation'=>'EAST']);

    }

    public function testIsPlaceCommandMustBeTheFirstCommand()
    {
        $this->expectException(LogicException::class);
        $this->robot->execute(['MOVE']);

        $this->expectException(LogicException::class);
        $this->robot->execute(['REPORT']);

        $this->expectException(LogicException::class);
        $this->robot->execute(['RIGHT']);

        $this->expectException(LogicException::class);
        $this->robot->execute(['LEFT']);

        $this->expectException(LogicException::class);
        $this->robot->execute(['LEFT']);
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['RIGHT']);
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['REPORT']);

        $this->robot->execute(['PLACE']);
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['RIGHT']);
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['MOVE']);
        $this->robot->execute(['REPORT']);
        $this->assertEquals($this->place->getPosition(),['x'=>2, 'y'=>2, 'orientation'=>'EAST']);

    }


    public function testExcpetionIsThrownWhenInvalidCommandIsParsed()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->robot->execute(['MOve']);

        $this->expectException(InvalidArgumentException::class);
        $this->robot->execute(['ukjkjh']);

        $this->expectException(InvalidArgumentException::class);
        $this->robot->execute('RIGHT');

        $this->expectException(InvalidArgumentException::class);
        $this->robot->execute(['LEFT  ']);

        $this->expectException(InvalidArgumentException::class);
        $this->robot->execute([123]);

    }

    public function testGetCommandsFromConfigClassReturnsArrayOfPermissibleCommands()
    {
        $this->assertIsArray($this->robot->getCommands());
    }

}