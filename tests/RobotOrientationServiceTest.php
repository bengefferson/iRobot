<?php
declare(strict_types=1);

namespace Test;
session_start();

use iRobot\TwoDimension\Service\RobotOrientationService;
use Test\TestCase;
use InvalidArgumentException;

class RobotOrientationServiceTest extends TestCase
{

    public function setUp() :void
    {
        parent::setUp();

        $this->orientation = $this->mock(RobotOrientationService::class);
    }


    public function testGetPossibleOrientationsReturnsArrayFromConfigClass()
    {
        $this->assertIsArray($this->orientation->getOrientations());
    }

    public function testGetPossibleRotationsReturnsArrayFromConfigClass()
    {
        $this->assertIsArray($this->orientation->getRotations());
    }

    public function testGetOrientationMapReturnsArrayWhenPermitedRotationIsParsed()
    {
        $this->assertIsArray($this->orientation->orientationMap('Left'));
        $this->assertIsArray($this->orientation->orientationMap('RIGHT'));
        $this->assertIsArray($this->orientation->orientationMap('left'));
        $this->assertIsArray($this->orientation->orientationMap(' riGht '));
    }

    public function testIsPermissibleOrientationReturnsTrueWhenPermitedOrientationIsParsed()
    {
        $this->assertTrue($this->orientation->isPermissibleOrientation('north'));
        $this->assertTrue($this->orientation->isPermissibleOrientation('west '));
        $this->assertTrue($this->orientation->isPermissibleOrientation('EAST'));
        $this->assertTrue($this->orientation->isPermissibleOrientation(' SoUth '));
    }

    public function testIsPermissibleOrientationThrowsExceptionsWhenOrientationNotConfigured()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->orientation->isPermissibleOrientation('up');

        $this->expectException(InvalidArgumentException::class);
        $this->orientation->isPermissibleOrientation('le ft');

        $this->expectException(InvalidArgumentException::class);
        $this->orientation->isPermissibleOrientation('rAnDom1');

        $this->expectException(InvalidArgumentException::class);
        $this->orientation->isPermissibleOrientation(134);
    }

    public function testOrientationAfterRotationGivesExpectedOrientationWhenValidRotationAndOrientatioAreParsed()
    {
        $this->assertEquals($this->orientation->orientationAfterRotation('left', ' north'),'WEST');
        $this->assertEquals($this->orientation->orientationAfterRotation('leFt', 'west'), 'SOUTH');
        $this->assertEquals($this->orientation->orientationAfterRotation('LeFt', 'EAST'), 'NORTH');
        $this->assertEquals($this->orientation->orientationAfterRotation(' LEFT ', 'SoUth'), 'EAST');
        $this->assertEquals($this->orientation->orientationAfterRotation('RIGHT', 'north'), 'EAST');
        $this->assertEquals($this->orientation->orientationAfterRotation('Right', 'west '), 'NORTH');
        $this->assertEquals($this->orientation->orientationAfterRotation(' right', 'EAST'), 'SOUTH');
        $this->assertEquals($this->orientation->orientationAfterRotation('Right ', 'SoUth'), 'WEST');
    }

}