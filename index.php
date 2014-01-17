<?php

	$_ELF=array(
		"tmp"=>dirname(__FILE__)."/tmp/",
	);

	include(dirname(__FILE__)."/elf-runtime/inc.php");


	echo $_ELF->_DEBUG->flush("<hr />"."<h1>DEBUG</h1>"."<hr />");


	$od=opendir($_ELF->_config["tmp"]);
	while ($rd=readdir($od))
	{
		if ($rd!="." AND $rd!="..")
		{
			unlink($_ELF->_config["tmp"].$rd);
		}
	}
	closedir($od);