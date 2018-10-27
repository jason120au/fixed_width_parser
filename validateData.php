<?php

function validateData($dataType,$data)
{
	if(strtolower($dataType) == "string")
	{
		$re = '/^[a-z].*/mi';
		$result = preg_match_all($re, $data, $matches, PREG_SET_ORDER, 0);
		if($result==1)
		{
			return true;
		}
		else
		{
			return 0;
		}
	}
	if(strtolower($dataType) == "date")
	{
		$re = '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';
		$result = preg_match_all($re, $data, $matches, PREG_SET_ORDER, 0);
		if($result==1)
		{
			return true;
		}
		else
		{
			return 0;
		}
	}

	if(strtolower($dataType) == "numeric")
	{
		$re = '/^[0-9]\d*(\.\d+)?$/mi';
		$result = preg_match_all($re, $data, $matches, PREG_SET_ORDER, 0);
		if($result==1)
		{
			return true;
		}
		else
		{
			return 0;
		}
	}
	
	
	if(strtolower($dataType) == "double")
	{
		$re = '/^[0-9]\d*(\.\d+)?$/mi';
		$result = preg_match_all($re, $data, $matches, PREG_SET_ORDER, 0);
		if($result==1)
		{
			return true;
		}
		else
		{
			return 0;
		}
	}
	
	if(strtolower($dataType) == "integer")
	{
		$re = '/(?<=\s|^)\d+(?=\s|$)/mi';
		$result = preg_match_all($re, $data, $matches, PREG_SET_ORDER, 0);
		if($result==1)
		{
			return true;
		}
		else
		{
			return 0;
		}
	}
}

?>