<?php

if(count($argv) <> 4)
{
	echo "Incorrect command usage\n";
	echo "Usage: parse.php <meta_data_file> <fixed width file> <output file>\n";
	exit();
}	
var_dump($argv);
?>