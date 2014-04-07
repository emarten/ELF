<?php

	function inputval($str)
	{
		$str=htmlspecialchars($str);
		return $str;
	}
	
	function postval($key)
	{
		$ret="";
		if (isset($_POST[$key]))
		{
			$ret=$_POST[$key];
		}
		return $ret;
	}