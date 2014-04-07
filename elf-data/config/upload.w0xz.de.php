<?php
	$config=array(
		"alias"=>array(
			"upload.w0xz.de/"
		),
	);
	$config["time2live"]=(1*60*60*24)*7;
	$config["debug_flush"]=false;
	$config["name"]="xUpload";
	$config["time_to_wait_for_download"]=1;

	$config["software"]=array( dirname(dirname(dirname(__FILE__)))."/_software/w0xz_upload/w0xz_Upload.class.php", "w0xz_Upload");

	$config["DB"]=array(
	    "type"=>"mysql",
	    "host"=>"localhost",
	    "name"=>"elf_w0xz",
	    "user"=>"elf",
	    "pass"=>"xuseru59",
	    "prefix"=>"uplx_"
	);
	
	$config["assign"]=array(
		"siteName"=>"xUpload"
	);

