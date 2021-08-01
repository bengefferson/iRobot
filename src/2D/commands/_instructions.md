# Command File Instructions

- To run commands, create a file in this directory.
- The file should follow the format of the sample 'commands.txt' file.
- Commands are not case sensitive.
- Commands should always start with the 'PLACE' method, followed by a space and the coordinates and orientation. For example:
```plain
PLACE 1,2,EAST
```
- Command 'PLACE' without arguments defauls to 'PLACE 0,0,North'.
- To see the robots current position after a command, use 'REPORT'.
- Outputs are printed to STDOUT.
- See the commands.txt file for an example command.