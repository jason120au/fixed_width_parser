<?php
$times = 10000000;
$count = 0;
$contents = file_get_contents("fixed_width_file.txt");

while($count < $times)
{
	
	file_put_contents("testData.txt",$contents,FILE_APPEND);
	echo $count . "\n";
	$count++;
}




?>