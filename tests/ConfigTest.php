<?php
declare(strict_types=1);

namespace Test;
session_start();

use iRobot\TwoDimension\Config;
use Test\TestCase;
use InvalidArgumentException;
use Exception;

class ConfigTest extends TestCase
{

    public function setUp() :void
    {
        parent::setUp();

        $this->config = $this->mock(Config::class);
    }


    public function testPossibleOrientationsReturnsArray()
    {
        $this->assertIsArray($this->config->possibleOrientations());
    }

    public function testPossibleRotationsReturnsArray()
    {
        $this->assertIsArray($this->config->possibleRotations());
    }

    public function testPossibleCommandsReturnsArray()
    {
        $this->assertIsArray($this->config->possibleCommands());
    }

    public function testGetBoardWidthReturnsDefaultBoardWidth()
    {
        $this->assertEquals($this->config->getBoardWidth(), 6);
        $this->assertIsInt($this->config->getBoardWidth());
    }

    public function testGetBoardLengthReturnsDefaultBoardLength()
    {
        $this->assertEquals($this->config->getBoardLength(), 6);
        $this->assertIsInt($this->config->getBoardLength());
    }

    public function testOrientationMapThatMatchesPossibleOrientationsReturnsArray()
    {
        $this->assertIsArray($this->config->getOrientationMap());
    }

    public function testBoardDimensionsReturnsArrayWhenConfiguredShapeIsParsed()
    {
        $this->assertIsArray($this->config->boardDimensions('square'));
    }

    public function testBoardDimensionsReturnsExpectedOutputWhenConfiguredShapeIsParsed()
    {
        $this->assertEquals($this->config->boardDimensions('square'),['length'=>6, 'width'=>6]);
    }

    public function testBoardDimensionsThrowsExceptionWhenUnconfiguredShapeIsParsed()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->config->boardDimensions('circle');
    }

}