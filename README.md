# iRobot Challenge

## Description

- The application is a simulation of a toy robot moving on a square tabletop, of dimensions 5 units x 5 units.
- There are no other obstructions on the table surface.
- The robot is free to roam around the surface of the table, but must be prevented from falling to destruction. Any movement
  that would result in the robot falling from the table must be prevented, however further valid movement commands must still
  be allowed.

Create an application that can read in commands of the following form:

```plain
PLACE X,Y,F
MOVE
LEFT
RIGHT
REPORT
```

- PLACE will put the toy robot on the table in position X,Y and facing NORTH, SOUTH, EAST or WEST.
- The origin (0,0) can be considered to be the SOUTH WEST most corner.
- The first valid command to the robot is a PLACE command, after that, any sequence of commands may be issued, in any order, including another PLACE command. The application should discard all commands in the sequence until a valid PLACE command has been executed.
- MOVE will move the toy robot one unit forward in the direction it is currently facing.
- LEFT and RIGHT will rotate the robot 90 degrees in the specified direction without changing the position of the robot.
- REPORT will announce the X,Y and orientation of the robot.
- A robot that is not on the table can choose to ignore the MOVE, LEFT, RIGHT and REPORT commands.
- Provide test data to exercise the application.

## Constraints

The toy robot must not fall off the table during movement. This also includes the initial placement of the toy robot.
Any move that would cause the robot to fall must be ignored.

Example Input and Output:

```plain
PLACE 0,0,NORTH
MOVE
REPORT
Output: 0,1,NORTH
```

```plain
PLACE 0,0,NORTH
LEFT
REPORT
Output: 0,0,WEST
```

```plain
PLACE 1,2,EAST
MOVE
MOVE
LEFT
MOVE
REPORT
Output: 3,3,NORTH
```

## SetUp

- The host computer must have docker and docker-compose installed and running.

- Clone this repository:

```plain
git clone git@github.com:bengefferson/iRobot.git
```

- cd to iRobot

- Bring up docker-compose using the command:

```plain
docker-compose up -d
```

- Update dependencies by running the following commands:

```plain
docker-compose exec app composer update
docker-compose exec app composer -- dump
```


## Running Simulation

- To run simulation from a file, create a file in the src/2D/commands directory

- Run the following command:

```plain
docker-compose exec app php simulate.php name_of_file.txt
```

- Read the src/2D/commands/_instructions.md file for instructions on how to setup a commands file

- The example file in the src/2D/commands directory can be run with the command:

```plain
docker-compose exec app php simulate.php commands.txt
```

- To run commands directly from the commandline, use the same command as above without parsing the file name as follows:

```plain
docker-compose exec app php simulate.php
```

## Running Test Suite

- Run the test suite with the following command:

```plain
docker-compose run phpunit --testdox tests
```

