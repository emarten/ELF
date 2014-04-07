<?php
#http://upload.w0xz.de/download/89a6365888d4f4d6894ae5d98cefdcae/
#http://upload.w0xz.de/download/89a6365888d4f4d6894ae5d98cefdcae/

	$ttw=$_ELF->_config["time_to_wait_for_download"];
	#$ttw=10;
	
	
	$execute_url="get_file";

	$check=new Cookie("download_ident");
	$download=false;
	if ($this->_assign->download==$execute_url)
	{
		$this->_assign->download=$check->get("file");
		$download=true;
	}

	$file=new FileUpload($this->_assign->download);
	#print_r($file);
	
	if (!$file->_exists)
	{
		header("HTTP/1.1 410 Gone");
		header("Location: ".$_ELF->_REQUEST->siteURL."404/");
		echo "<h1>HTTP/1.1 301 Moved Permanently</h1>\nLocation: ".$_ELF->_REQUEST->siteURL."404/\r\n";
		exit;
	}
	
	if ($download)
	{
		#print_r($file);
		if ($check->get("not_before")>time())
		{
			
			$this->_assign->location=$_ELF->_REQUEST->siteURL."download/".$execute_url."/";	
			$tl=$check->get("not_before")-time();
			$this->_assign->time_left=$tl;
			$this->_assign->time_left_ms=$tl*1000;
			
		}
		else
		{
			$check->destroy();

			$datei = $file->path;
			$dateiname = $file->name;
			$groesse = filesize($datei);
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"".$dateiname."\"");
			header("Content-Length:".$groesse);
			readfile($datei);
			#$file->update("downloads",($file->downloads+1));
			$file->downloads++;
			$file->last_download=time();
			$file->save();
			exit;
		}
	}
	else {
		$check->set("file",$this->_assign->download);
		$check->set("not_before",time()+$ttw);
		#header("HTTP/1.1 200 OK");
		#header("Location: ".$_ELF->_REQUEST->siteURL."download/$execute_url/");
		#echo "<h1>HTTP/1.1 200 OK</h1>\nLocation: ".$_ELF->_REQUEST->siteURL."download/$execute_url/\r\n";	
		$this->_assign->location=$_ELF->_REQUEST->siteURL."download/".$execute_url."/";
			$tl=$ttw;
			$this->_assign->time_left=$tl;
			$this->_assign->time_left_ms=$tl*1000;
	}
	
	
	#exit;