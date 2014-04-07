<?php


function inc_func_dir($dir)
{
	$od=opendir($dir);
	while ($rd=readdir($od))
	{
		if (substr($rd,0,1)!="." AND $rd!="inc.php")
		{
			if (is_dir($dir.$rd))
			{
				inc_func_dir($dir.$rd."/");
			}
			else
			{
				include($dir.$rd);
			}
		}
	}
	closedir($od);
}

inc_func_dir(dirname(__FILE__)."/");

#	