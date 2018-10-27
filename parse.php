<?php

/*
This file takes a fixed width data file and a meta data specification file and will output a parsed CSV file.

To execute run

php parse.php <meta_data_file> <fixed width file> <output file> 

By Jason Campbell (c) 2018

*/

error_reporting(0);
include("validateData.php");

// Check for valid command parameters
if(count($argv) <> 4)
{
	echo "Incorrect command usage\n";
	echo "Usage: parse.php <meta_data_file> <fixed width file> <output file>\n";
	exit();
}

// Once we have valid parameters assign them to variables
$specFile = $argv[1];
$fixedWidthFile  = $argv[2];
$outputFile = $argv[3];

//Read the meta data file
$file = fopen($specFile,"r") or die("Cannot open Meta Setup file \n");
$outputFile = 'output.txt';
$count = 1;
$headerArray = [];

//Read the full contents of the meta data file
while(!feof($file))
{
	
	$fieldSpec =  trim(fgets($file));
	
	if(strlen($fieldSpec) == 0)
	{
		break;
	}
	else
	{
		// Check specification file meets specifications
		if(substr_count($fieldSpec,",") <> 2)// && $count > 0)
		{
			echo "Specification file $specFile incorrect format on line " . $count ."\n";
			exit();
		}	
		$meta_data[] = str_getcsv($fieldSpec);
	}
	
	
	$count++;

}
// Create an array of only the header elements
foreach($meta_data as $spec)
{	
	$headerArray[] = $spec[0];
	
}

// Output the header data to the file specified on the command line parsing for valid CSV
file_put_contents($outputFile,generateCsv($headerArray));

// Close the file
fclose($file);

// Call the parse function
$data = parse_fixed_width($meta_data);

// Function to parse an input string for valid CSV ie strings that contain "," are enclosed with quote marks
function generateCsv($data, $delimiter = ',', $enclosure = '"') {
       
	$count = 0;
	$contents = "";
	$handle = fopen('php://temp', 'r+');
	fputcsv($handle, $data, $delimiter, $enclosure);
   
	rewind($handle);
	while (!feof($handle)) 
	{
		$contents .= fread($handle, 8192);
	}
	
	// Replace LF with CRLF
    $contents = str_replace("\n", "\r\n", $contents);
    fclose($handle);
    $count++;
    return $contents;
}
function parse_fixed_width($meta_data)
{
	//Declare varables and open the Data file	
	global $outputFile;
	global $fixedWidthFile;
	
	$file = fopen($fixedWidthFile,"r") or die("Cannot open $outputFile for writing\n");
	$count = 0;
	$lineCount = 0;
	$offset = 0;
	$dataRow = "";
	$fields = "";
	$count =0;
	
	while(! feof($file))
	{
		// Get a row of data from the fixed width file and remove leading and trailing white space as well as CR LF etc
		$row = rtrim(trim(fgets($file)));
		
		// Parse a row of data from the fixed width data file 
		foreach($meta_data as $length)
		{
			$offset = $offset + (int)$length[1];
			$fields = trim(substr($row,$offset-$length[1],$length[1]));
						
		    if(strlen($fields) ==0)
			{
				echo "";
			}
			else
			{
				// Validate the data	
				if(validateData($length[2],$fields) <> true)
				{
					$lineCount = $lineCount + 1;
					echo "Data on line $lineCount of $fixedWidthFile is invalid expecting " . $length[2] . "\n";
					file_put_contents($outputFile,"");
					exit();
				}
				else
				{
					$dataFields[$count] = $fields;
				}
			}
			$count++;
		}
		
		// If the data is longer than the meta data file it's invalid
		if(strlen($row) > $offset)
		{
			$lineCount = $lineCount + 1;
			echo "Line $lineCount is invalid in $fixedWidthFile\n";
			exit();
		}
		
		file_put_contents($outputFile,generateCsv($dataFields), FILE_APPEND);
		$offset = 0;  
		$lineCount++;
		$dataFields = [];
	}
	fclose($file);
	return $dataFields;	 
}




?>
