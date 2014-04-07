<?php

global $_ELF;

	if ($_ELF->_REQUEST->mode!="api")
	{
		exit;
	}

	$livetime=$_ELF->_config["time2live"];

	$delfiles=0;
	$deldirs=0;

	$this->_assign->API->success=true;

	#print_r($this);

	$tempdir=$this->_includeDirectory."temp/";

	$sql=$_ELF->_DB->prepare("SELECT * FROM `".DB_PREFIX."FileUpload` WHERE `date` <= :date");
	$sql->execute(array(
		"date"=>time()-$livetime
	));
	while ($row=$sql->fetch(PDO::FETCH_ASSOC))
	{
		if ( ($row["last_download"]<time()-$livetime OR $row["downloads"]<=0) AND $row["credits"]<=0 )
		{
			@unlink($row["path"]);
			$ssql="DELETE FROM `".DB_PREFIX."FileUpload` WHERE `id` = '".$row["id"]."'";
			$ssql=$_ELF->_DB->prepare($ssql);
			$ssql->execute();
			$delfiles++;
		}
		else
		{
			if ( ($row["last_download"]<time()-$livetime OR $row["downloads"]<=0) AND $row["credits"]>=1 )
			{
				if ($row["last_cron"]<=time()-60*60*24)
				{
					$file=new FileUpload($row["fid"]);
					$file->credits--;
					$file->last_cron=time();
					#$file->last_download=time();
					#$file->downloads++;
					$file->save();
				}
			}
		}
	}

	function list_dirs($dir)
	{
		$od=opendir($dir);
		$pathes=array();
		while ($rd=readdir($od))
		{
			if (substr($rd,0,1)!=".")
			{
				if (is_dir($dir.$rd))
				{
					array_push($pathes,$dir.$rd."/");
					$re=list_dirs($dir.$rd."/");
					foreach ($re as $r)
					{
						array_push($pathes,$r);
					}
				}
			}
		}
		closedir($od);
		return $pathes;
	}

	$temp=list_dirs($tempdir);
	$temp=  array_reverse($temp);
	#print_r($temp);

	foreach ($temp as $t)
	{
		$files=0;
		$od=opendir($t);
			while ($rd=readdir($od))
			{
				if (substr($rd,0,1)!=".")
				{
					$files++;
				}
			}
		closedir($od);
		if ($files<=0)
		{
			shell_exec("rm -rf $t");
			$deldirs++;
			#echo "del $t \n";
		}
	}


	$this->_assign->API->deletedFiles=$delfiles;
	$this->_assign->API->deletedDirectories=$deldirs;






