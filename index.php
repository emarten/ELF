<?php

	$_ELF=array(
		"tmp"=>dirname(__FILE__)."/tmp/",
		"debug"=>true,
		"tmp_age"=>1
	);

	include(dirname(__FILE__)."/elf-runtime/inc.php");


	echo $_ELF->_DEBUG->flush("<hr />"."<h1>DEBUG</h1>"."<hr />");


