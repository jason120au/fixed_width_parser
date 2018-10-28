# Fixed Width Parser

Parses a fixed width file based on a meta data specification file. Written in PHP.

To run execute

php <meta_data_file> <fixed_width_file> <output file>

# File List

fileOutput.php - Test file output not required
fixed_width_file.txt - Test input file
genTestData.php - Generate test data by copying the test data file muluiple times will generate a file of several GB in size using the default setting
getArgs.php - Test command line arguments
meta_data_file.txt - Setup file with specification of each field in the data
output.txt - The parsed output
parse.php - Main paese file requires validateData.php
validateDate.php - Validates the data received in the input file

