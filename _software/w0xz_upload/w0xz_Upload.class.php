<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of w0xz_Upload
 *
 * @author Eric
 */
class w0xz_Upload extends ELF_Software
{
	public function init()
	{
		
		global $_ELF;
		if (isset($_ELF->_config["name"]))
		{
			$this->name=$_ELF->_config["name"];
		}
		else
		{
			$this->name="Unnamed Upload Service";
		}
		$this->Session=new Cookie("Session");
		
		$file=$_ELF->_REQUEST->URLname;
		if (empty($file) OR $file=="/")
		{
			$file="index";
		}
		
		$temp=explode("/",$file);
		if ($temp[0]=="dl" OR $temp[0]=="download")
		{
			if (isset($temp[1]))
			{
				$file="download";
				$this->_assign->download=$temp[1];
				if ($temp[0]=="dl")
				{
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: ".$_ELF->_REQUEST->siteURL."download/".$temp[1]."/");
					echo "<h1>HTTP/1.1 301 Moved Permanently</h1>\nLocation: ".$_ELF->_REQUEST->siteURL."download/".$temp[1]."/\r\n";
					exit;
				}
			}
			else
			{
				$file="404";
			}
		}

		if ($this->Session->bool("online"))
		{
			$tfile=dirname(__FILE__)."/template/online/".$file.".php";
		}
		else
		{
			$tfile=dirname(__FILE__)."/template/offline/".$file.".php";
		}
		
		if ($this->Session->bool("online") AND !file_exists($tfile))
		{
			$tfile=dirname(__FILE__)."/template/offline/".$file.".php";
		}
		
		if (!file_exists($tfile))
		{
			$tfile=dirname(__FILE__)."/template/404.php";
		}
		
		$afile=dirname(__FILE__)."/assign/".substr($tfile,strlen(dirname(__FILE__)."/template/"));
		if (file_exists($afile))
		{
			include($afile);
		}
		
		
		$this->_assign->content_file1=$tfile;
		$this->_assign->templateDIR=dirname(__FILE__)."/template/";
		$tfile=dirname(__FILE__)."/template/index.php";
		
		if (!isset($this->_assign->title))
		{
			$this->_assign->title=$this->name;
		}
		
		$this->Template=$_ELF->loadTemplate($tfile);
	}
}

?>
