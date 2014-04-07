	$identifier="default";
	
<?php

	global $_ELF;
/*
	if (!isset($_COOKIE["_identifier"]))
	{
		$identifier=md5(time().rand(1,99999).microtime(true).$_SERVER["REMOTE_ADDR"]);
		setcookie("_identifier", $identifier, 0, $_ELF->_REQUEST->baseDirectory);
		$_COOKIE["_identifier"]=$identifier;
	}
/**/
	$return = new Cookie($identifier);
	
	