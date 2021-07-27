<?php
declare(strict_types=1);
namespace Test;
session_start();

use iRobot\TwoDimension\Service\MoveRobotService;
use iRobot\TwoDimension\Service\PlaceRobotService;
use iRobot\TwoDimension\Robot;
use iRobot\TwoDimension\Board\SquareBoard;
use Test\TestCase;
use iRobot\Simulator;
use LogicException;
use InvalidArgumentException;

class SimulatorTest extends TestCase
{

    public function setUp() :void
    {
        parent::setUp();

        $this->board = $this->mock(SquareBoard::class);
        $this->place = $this->mock(PlaceRobotService::class, [$this->board]);
        $this->move = $this->mock(MoveRobotService::class, [$this->place]);
        $this->robot = $this->mock(Robot::class, [$this->place,$this->move]);
        $this->simulator = $this->mock(Simulator::class, [$this->robot]);
    }

    public function testRunExecutesCommandsTheExpectedNumberOfTimes()
    {
        $this->robot->shouldReceive('execute')->times(6);
        $this->simulator->run('tests/data/test.txt');
    }

    
}