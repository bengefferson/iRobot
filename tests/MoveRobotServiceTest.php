<?php
declare(strict_types=1);
namespace Test;
session_start();

use iRobot\TwoDimension\Service\MoveRobotService;
use iRobot\TwoDimension\Service\PlaceRobotService;
use iRobot\TwoDimension\Board\SquareBoard;
use Test\TestCase;
use LogicException;

class MoveRobotServiceTest extends TestCase
{
 
    public function setUp() :void
    {
        parent::setUp();

        $this->board = $this->mock(SquareBoard::class);
        $this->place = $this->mock(PlaceRobotService::class, [$this->board]);
        $this->move = $this->mock(MoveRobotService::class, [$this->place]);
    }

    public function testMoveForwardMovesAPlacedRobotForwardWRTCurrentOrientation()
    {
        $this->place->placeOnBoard();
        $this->move->moveForwardWRTOrientation();
        $this->assertEquals($this->place->getPosition(),['x'=>0, 'y'=>1, 'orientation'=>'NORTH']);

        $this->place->placeOnBoard(3,4,' east ');
        $this->move->moveForwardWRTOrientation();
        $this->assertEquals($this->place->getPosition(),['x'=>4, 'y'=>4, 'orientation'=>'EAST']);

        $this->place->placeOnBoard(6,6,'south');
        $this->move->moveForwardWRTOrientation();
        $this->assertEquals($this->place->getPosition(),['x'=>6, 'y'=>5, 'orientation'=>'SOUTH']);

        $this->place->placeOnBoard(1,6,' west');
        $this->move->moveForwardWRTOrientation();
        $this->assertEquals($this->place->getPosition(),['x'=>0, 'y'=>6, 'orientation'=>'WEST']);
    }

    public function testRotateChangesThisOrientationOfThePlacedRobotWhenARotationIsParsed()
    {
        $this->place->placeOnBoard();
        $this->move->rotate('RIGHT');
        $this->assertEquals($this->place->getPosition(),['x'=>0, 'y'=>0, 'orientation'=>'EAST']);

        $this->place->placeOnBoard(3,4,' east ');
        $this->move->rotate('leFt');
        $this->assertEquals($this->place->getPosition(),['x'=>3, 'y'=>4, 'orientation'=>'NORTH']);

        $this->place->placeOnBoard(6,6,'south');
        $this->move->rotate(' right ');
        $this->assertEquals($this->place->getPosition(),['x'=>6, 'y'=>6, 'orientation'=>'WEST']);

        $this->place->placeOnBoard(0,6,' west');
        $this->move->rotate('leFt ');
        $this->assertEquals($this->place->getPosition(),['x'=>0, 'y'=>6, 'orientation'=>'SOUTH']);
    }

    public function testGetMovementUnitReturnsAnIntegerFromConfigClass()
    {
        $this->assertIsInt($this->move->getMovementUnit());
    }





}